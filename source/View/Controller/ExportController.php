<?php

namespace App\View\Controller;


use App\Domain\Model\Study\Experiment;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @IsGranted("ROLE_USER")
 */
class ExportController extends AbstractController
{

    private LoggerInterface $logger;
    private EntityManagerInterface $em;
    private Serializer $serializer;

    /**
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $em
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $em)
    {
        $this->logger = $logger;
        $this->em = $em;
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);
        $this->serializer = new Serializer(
            [new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter)],
            ['json' => new JsonEncoder(), 'xml' => new XmlEncoder(), 'csv' => new CsvEncoder()]
        );
    }


    /**
     * @Route("/export/{uuid}", name="export_index")
     *
     * @param string $uuid
     * @return Response
     * @throws ExceptionInterface
     */
    public function exportAction(string $uuid): Response
    {
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);
        $json = $this->serializer->serialize(
            $experiment,
            'xml',
            [
                'xml_root_node_name' => 'study',
                'xml_encoding' => 'utf-8',
                'xml_format_output' => true,
                AbstractNormalizer::GROUPS => ["study"],
                'json_encode_options' => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
            ]
        );
        $this->logger->debug("Enter ExportController::exportAction for UUID: $uuid");

        return $this->render('Pages/Export/export.html.twig', ['json' => $json]);
    }
}