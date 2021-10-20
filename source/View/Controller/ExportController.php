<?php

namespace App\View\Controller;


use App\Domain\Model\Filemanagement\Dataset;
use App\Domain\Model\Study\Experiment;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use ZipArchive;

/**
 * @IsGranted("ROLE_USER")
 */
class ExportController extends AbstractController
{

    private LoggerInterface $logger;
    private EntityManagerInterface $em;
    private Serializer $serializer;
    private Filesystem $filesystem;

    /**
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $em
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $em, Filesystem $filesystem)
    {
        $this->logger = $logger;
        $this->em = $em;
        $this->filesystem = $filesystem;
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);
        $this->serializer = new Serializer(
            [new DateTimeNormalizer(), new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter)],
            ['json' => new JsonEncoder(), 'xml' => new XmlEncoder(), 'csv' => new CsvEncoder()]
        );
    }


    /**
     * @Route("/export/{uuid}", name="export_index", methods={"GET"})
     *
     * @param string $uuid
     * @return Response
     * @throws ExceptionInterface
     */
    public function exportIndex(string $uuid): Response
    {
        $this->logger->debug("Enter ExportController::exportAction(GET) for UUID: $uuid");
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);
        $json = $this->serializer->serialize(
            $experiment,
            'json',
            [
                'xml_root_node_name' => 'study',
                'xml_encoding' => 'utf-8',
                'xml_format_output' => true,
                AbstractNormalizer::GROUPS => ["study", "non_experimental", 'dataset', 'codebook'],
                'json_encode_options' => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
            ]
        );

        return $this->render('Pages/Export/export.html.twig', ['json' => json_decode($json), "experiment" => $experiment]);
    }

    /**
     * @Route("/export/{uuid}", name="export_action", methods={"POST"})
     *
     * @param Request $request
     * @param string $uuid
     * @return Response
     */
    public function exportAction(Request $request, string $uuid): Response
    {
        $this->logger->debug("Enter ExportController::exportAction(POST) for UUID: $uuid");
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);
        $exportFormat = $request->get('exportFormat');
        $exportDataset = $request->get('exportDataset');
        if ($experiment) {
            $zip = new ZipArchive();
            $zipName = sys_get_temp_dir().'/test.zip';
            if ($zip->open($zipName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $experiment->getOriginalDatasets()->clear();
                if (null !== $exportDataset && 0 != sizeof($exportDataset)) {
                    foreach ($exportDataset as $dataset) {
                        $experiment->addOriginalDatasets($this->em->getRepository(Dataset::class)->find($dataset));
                    }
                    $this->appendDatasetToZip($experiment, $exportFormat, $zip);
                }
                if ('study' === $request->get('exportStudy')) {
                    $this->appendStudyToZip($experiment, $exportFormat, $zip);
                }
                if ($zip->numFiles != 0) {
                    $zip->close();
                    $response = new Response(
                        file_get_contents($zipName),
                        Response::HTTP_OK,
                        [
                            'Content-Type' => 'application/zip',
                            'Content-Disposition' => 'attachment; filename="'.basename($zipName).'"',
                            'Content-Length' => filesize($zipName),
                        ]
                    );
                } else {
                    $zip->addFromString('empty.txt', 'No file exported!');
                    $zip->close();
                    // TODO ERROR HANDLING
                }
                unlink($zipName);
            } else {
                // TODO ERROR HANDLING
            }
        }

        return $response ?? $this->render('Pages/Export/export.html.twig', ['json' => null, "experiment" => $experiment]);
    }

    /**
     * @param Experiment $experiment
     * @param string $format
     * @param ZipArchive $zip
     */
    private function appendStudyToZip(Experiment $experiment, string $format, ZipArchive &$zip)
    {
        $design = "Experimental" === $experiment->getMethodMetaDataGroup()->getResearchDesign(
        ) ? 'experimental' : ("Non-experimental" === $experiment->getMethodMetaDataGroup()->getResearchDesign() ? 'non_experimental' : null);

        $json = $this->serializer->serialize(
            $experiment,
            $format,
            [
                'xml_root_node_name' => 'study',
                'xml_encoding' => 'utf-8',
                'xml_format_output' => true,
                AbstractNormalizer::GROUPS => ['study', 'dataset', $design],
                'json_encode_options' => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
            ]
        );

        $zip->addFromString('study.'.$format, $json);
    }

    /**
     * @param Experiment $experiment
     * @param ZipArchive $zip
     */
    private function appendDatasetToZip(Experiment $experiment, string $format, ZipArchive &$zip)
    {
        foreach ($experiment->getOriginalDatasets() as $dataset) {
            $folderName = $dataset->getOriginalName();
            if (str_contains($folderName, '.')) {
                $folderName = explode('.', $folderName)[0];
            }
            $folder = 'datasets/'.$folderName;
            $zip->addEmptyDir($folder);
            if ($this->filesystem->has($dataset->getStorageName())) {
                try {
                    $zip->addFromString("$folder/original_".$dataset->getOriginalName(), $this->filesystem->read($dataset->getStorageName()));
                } catch (FileNotFoundException $e) {
                    // TODO
                }
            }
            /*$zip->addFromString(
                "$folder/codebook.csv",
                $this->serializer->serialize($dataset->getCodebook(), 'csv', [AbstractNormalizer::GROUPS => 'codebook', 'output_utf8_bom' => true])
            );*/
            $zip->addFromString(
                "$folder/codebook.$format",
                $this->serializer->serialize(
                    $dataset->getCodebook(),
                    $format,
                    [
                        'xml_root_node_name' => 'codebook',
                        'xml_encoding' => 'utf-8',
                        'xml_format_output' => true,
                        AbstractNormalizer::GROUPS => ['codebook'],
                        'json_encode_options' => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
                    ]
                )
            );
        }
    }

}