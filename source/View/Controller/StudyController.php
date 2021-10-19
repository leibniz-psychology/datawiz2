<?php

namespace App\View\Controller;

use App\Crud\Crudable;
use App\Domain\Model\Study\CreatorMetaDataGroup;
use App\Domain\Model\Study\Experiment;
use App\Questionnaire\Questionnairable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/studies", name="Study-")
 * @IsGranted("ROLE_USER")
 *
 * Class StudyController
 * @package App\View\Controller
 */
class StudyController extends AbstractController
{
    private Security $security;
    private Questionnairable $questionnaire;
    private EntityManagerInterface $em;
    private LoggerInterface $logger;
    private Crudable $crud;

    /**
     * @param Security $security
     * @param Questionnairable $questionnaire
     * @param EntityManagerInterface $em
     * @param LoggerInterface $logger
     * @param Crudable $crud
     */
    public function __construct(Security $security, Questionnairable $questionnaire, EntityManagerInterface $em, LoggerInterface $logger, Crudable $crud)
    {
        $this->security = $security;
        $this->questionnaire = $questionnaire;
        $this->em = $em;
        $this->logger = $logger;
        $this->crud = $crud;
    }


    /**
     * @Route("/", name="overview")
     *
     * @return Response
     */
    public function overviewAction(): Response
    {
        $this->logger->debug("Enter StudyController::overviewAction");

        return $this->render('Pages/Study/overview.html.twig', [
            'all_experiments' => $this->em->getRepository(Experiment::class)->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new")
     *
     * @param Questionnairable $questionnaire
     * @param Crudable $crud
     * @param Request $request
     * @return Response
     */
    public function newAction(Questionnairable $questionnaire, Crudable $crud, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::newAction");
        $newExperiment = Experiment::createNewExperiment($this->security->getUser());
        $form = $questionnaire->askAndHandle($newExperiment->getSettingsMetaDataGroup(), 'create', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($newExperiment);
            $this->em->flush();

            return $this->redirectToRoute('Study-introduction', ['uuid' => $newExperiment->getId()]);
        }

        return $this->render('Pages/Study/new.html.twig', [
            'form' => $form->createView(),
            'experiment' => $newExperiment,
        ]);
    }

    /**
     * @Route("/{uuid}/settings", name="settings")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function settingsAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::settingsAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);
        $form = $this->questionnaire->askAndHandle($entityAtChange->getSettingsMetaDataGroup(), 'save', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($entityAtChange);
            $this->em->flush();
        }

        return $this->render('Pages/Study/settings.html.twig', [
            'form' => $form->createView(),
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/documentation", name="documentation")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function documentationAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::documentationAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);
        $basicInformation = $entityAtChange->getBasicInformationMetaDataGroup();
        if (sizeof($basicInformation->getCreators()) == 0) {
            $basicInformation->getCreators()->add(new CreatorMetaDataGroup());
        }
        $basicInformation->setRelatedPublications($this->prepareEmptyArray($basicInformation->getRelatedPublications()));
        $form = $this->questionnaire->askAndHandle($basicInformation, 'save', $request);
        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $formData = $form->getData();
            $currentCreators = $this->em->getRepository(CreatorMetaDataGroup::class)->findBy(['basicInformation' => $basicInformation]);
            if (is_iterable($currentCreators)) {
                foreach ($currentCreators as $currentCreator) {
                    $this->em->remove($currentCreator);
                }
            }
            if ($form->getData()->getCreators() !== null && is_iterable($form->getData()->getCreators())) {
                foreach ($formData->getCreators() as $creator) {
                    if (!$creator->isEmpty()) {
                        $creator->setCreditRoles(array_values(array_unique($creator->getCreditRoles())));
                        $creator->setBasicInformation($basicInformation);
                        $this->em->persist($creator);
                    } else {
                        $form->getData()->getCreators()->removeElement($creator);
                    }
                }
            }
            $formData->setRelatedPublications(array_filter($formData->getRelatedPublications()));
            $this->em->persist($formData);
            $this->em->flush();

            return $this->redirectToRoute('Study-documentation', ['uuid' => $uuid]);
        }

        return $this->render('Pages/Study/documentation.html.twig', [
            'form' => $form->createView(),
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/theory", name="theory")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function theoryAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::theoryAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);
        $form = $this->questionnaire->askAndHandle($entityAtChange->getTheoryMetaDataGroup(), 'save', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($entityAtChange);
            $this->em->flush();
        }

        return $this->render('Pages/Study/theory.html.twig', [
            'form' => $form->createView(),
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/sample", name="sample")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function sampleAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::sampleAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);
        $sampleGroup = $entityAtChange->getSampleMetaDataGroup();
        $sampleGroup->setPopulation($this->prepareEmptyArray($sampleGroup->getPopulation()));
        $sampleGroup->setInclusionCriteria($this->prepareEmptyArray($sampleGroup->getInclusionCriteria()));
        $sampleGroup->setExclusionCriteria($this->prepareEmptyArray($sampleGroup->getExclusionCriteria()));
        $form = $this->questionnaire->askAndHandle($entityAtChange->getSampleMetaDataGroup(), 'save', $request);
        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $formData = $form->getData();
            $formData->setPopulation(array_values($formData->getPopulation()));
            $formData->setInclusionCriteria(array_values($formData->getInclusionCriteria()));
            $formData->setExclusionCriteria(array_values($formData->getExclusionCriteria()));
            $this->em->persist($formData);
            $this->em->flush();
        }

        return $this->render('Pages/Study/sample.html.twig', [
            'form' => $form->createView(),
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/measure", name="measure")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function measureAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::measureAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);
        $entityAtChange->getMeasureMetaDataGroup()->setMeasures($this->prepareEmptyArray($entityAtChange->getMeasureMetaDataGroup()->getMeasures()));
        $entityAtChange->getMeasureMetaDataGroup()->setApparatus($this->prepareEmptyArray($entityAtChange->getMeasureMetaDataGroup()->getApparatus()));
        $form = $this->questionnaire->askAndHandle($entityAtChange->getMeasureMetaDataGroup(), 'save', $request);
        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $formData = $form->getData();
            $formData->setApparatus(array_filter($formData->getApparatus()));
            $formData->setMeasures(array_filter($formData->getMeasures()));
            $this->em->persist($formData);
            $this->em->flush();
        }

        return $this->render('Pages/Study/measure.html.twig', [
            'form' => $form->createView(),
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/method", name="method")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function methodAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::methodAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);
        $form = $this->questionnaire->askAndHandle($entityAtChange->getMethodMetaDataGroup(), 'save', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($entityAtChange);
            $this->em->flush();
        }

        return $this->render('Pages/Study/method.html.twig', [
            'form' => $form->createView(),
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/materials", name="materials")
     *
     * @param string $uuid
     * @return Response
     */
    public function materialsAction(string $uuid): Response
    {
        $this->logger->debug("Enter StudyController::materialsAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);

        return $this->render('Pages/Study/materials.html.twig', [
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/datasets", name="datasets")
     *
     * @param string $uuid
     * @return Response
     */
    public function datasetsAction(string $uuid): Response
    {
        $this->logger->debug("Enter StudyController::datasetsAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);

        return $this->render('Pages/Study/datasets.html.twig', [
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/introduction", name="introduction")
     *
     * @param string $uuid
     * @return Response
     */
    public function introductionAction(string $uuid): Response
    {
        $this->logger->debug("Enter StudyController::introductionAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);

        return $this->render('Pages/Study/introduction.html.twig', [
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/delete", name="delete")
     *
     * @param string $uuid
     * @return Response
     */
    public function deleteAction(string $uuid): Response
    {
        $this->logger->debug("Enter StudyController::deleteAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);
        $result = $this->crud->deleteStudy($entityAtChange);

        return $this->redirectToRoute('Study-overview');
    }


    protected function getEntityAtChange(string $uuid, string $className = Experiment::class)
    {
        return $this->em->getRepository($className)->find($uuid);
    }

    /**
     * @param array|null $array
     * @return array|string[]
     */
    private function prepareEmptyArray(?array $array): array
    {
        if (null === $array || 0 >= sizeof($array)) {
            $array = array("");
        }

        return $array;
    }
}
