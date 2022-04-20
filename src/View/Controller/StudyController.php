<?php

namespace App\View\Controller;

use App\Crud\Crudable;
use App\Domain\Definition\UserRoles;
use App\Domain\Model\Study\CreatorMetaDataGroup;
use App\Domain\Model\Study\Experiment;
use App\Questionnaire\Questionnairable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/studies", name="Study-")
 * @IsGranted("ROLE_USER")
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
            'all_experiments' => $this->em->getRepository(Experiment::class)->findBy(['owner' => $this->getUser()]),
        ]);
    }

    /**
     * @Route("/new", name="new")
     *
     * @param Questionnairable $questionnaire
     * @param Request $request
     * @return Response
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function newAction(Questionnairable $questionnaire, Request $request): Response
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
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);

        if (!$this->_checkAccess($experiment)) {
            return $this->redirectToRoute('dashboard');
        }

        $form = $this->questionnaire->askAndHandle($experiment->getSettingsMetaDataGroup(), 'save', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($experiment);
            $this->em->flush();
        }

        return $this->render('Pages/Study/settings.html.twig', [
            'form' => $form->createView(),
            'experiment' => $experiment,
        ]);
    }

    /**
     * @Route("/{uuid}/documentation", name="documentation")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function documentationAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::documentationAction with [UUID: $uuid]");
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);

        if (!$this->_checkAccess($experiment)) {
            return $this->redirectToRoute('dashboard');
        }

        $basicInformation = $experiment->getBasicInformationMetaDataGroup();
        if (sizeof($basicInformation->getCreators()) == 0) {
            $basicInformation->getCreators()->add(new CreatorMetaDataGroup());
        }
        $basicInformation->setRelatedPublications($this->_prepareEmptyArray($basicInformation->getRelatedPublications()));
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

            switch (true) {
                case $form->get('saveAndNext')->isClicked():
                    return $this->redirectToRoute('Study-theory', ['uuid' => $uuid]);
                default:
                    if ($response = $this->_routeButtonClicks($form, $uuid)) {
                        return $response;
                    }
            }

            return $this->redirectToRoute('Study-documentation', ['uuid' => $uuid]);
        }

        return $this->render('Pages/Study/documentation.html.twig', [
            'form' => $form->createView(),
            'experiment' => $experiment,
        ]);
    }

    /**
     * @Route("/{uuid}/theory", name="theory")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function theoryAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::theoryAction with [UUID: $uuid]");
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);

        if (!$this->_checkAccess($experiment)) {
            return $this->redirectToRoute('dashboard');
        }

        $form = $this->questionnaire->askAndHandle($experiment->getTheoryMetaDataGroup(), 'save', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($experiment);
            $this->em->flush();

            switch (true) {
                case $form->get('saveAndPrevious')->isClicked():
                    return $this->redirectToRoute('Study-documentation', ['uuid' => $uuid]);
                case $form->get('saveAndNext')->isClicked():
                    return $this->redirectToRoute('Study-method', ['uuid' => $uuid]);
                default:
                    if ($response = $this->_routeButtonClicks($form, $uuid)) {
                        return $response;
                    }
            }
        }

        return $this->render('Pages/Study/theory.html.twig', [
            'form' => $form->createView(),
            'experiment' => $experiment,
        ]);
    }

    /**
     * @Route("/{uuid}/sample", name="sample")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function sampleAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::sampleAction with [UUID: $uuid]");
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);

        if (!$this->_checkAccess($experiment)) {
            return $this->redirectToRoute('dashboard');
        }

        $sampleGroup = $experiment->getSampleMetaDataGroup();
        $sampleGroup->setPopulation($this->_prepareEmptyArray($sampleGroup->getPopulation()));
        $sampleGroup->setInclusionCriteria($this->_prepareEmptyArray($sampleGroup->getInclusionCriteria()));
        $sampleGroup->setExclusionCriteria($this->_prepareEmptyArray($sampleGroup->getExclusionCriteria()));
        $form = $this->questionnaire->askAndHandle($experiment->getSampleMetaDataGroup(), 'save', $request);
        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $formData = $form->getData();
            $formData->setPopulation(array_values($formData->getPopulation()));
            $formData->setInclusionCriteria(array_values($formData->getInclusionCriteria()));
            $formData->setExclusionCriteria(array_values($formData->getExclusionCriteria()));
            $this->em->persist($formData);
            $this->em->flush();

            switch (true) {
                case $form->get('saveAndPrevious')->isClicked():
                    return $this->redirectToRoute('Study-measure', ['uuid' => $uuid]);
                default:
                    if ($response = $this->_routeButtonClicks($form, $uuid)) {
                        return $response;
                    }
            }
        }

        return $this->render('Pages/Study/sample.html.twig', [
            'form' => $form->createView(),
            'experiment' => $experiment,
        ]);
    }

    /**
     * @Route("/{uuid}/measure", name="measure")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function measureAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::measureAction with [UUID: $uuid]");
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);

        if (!$this->_checkAccess($experiment)) {
            return $this->redirectToRoute('dashboard');
        }

        $experiment->getMeasureMetaDataGroup()->setMeasures($this->_prepareEmptyArray($experiment->getMeasureMetaDataGroup()->getMeasures()));
        $experiment->getMeasureMetaDataGroup()->setApparatus($this->_prepareEmptyArray($experiment->getMeasureMetaDataGroup()->getApparatus()));
        $form = $this->questionnaire->askAndHandle($experiment->getMeasureMetaDataGroup(), 'save', $request);
        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $formData = $form->getData();
            $formData->setApparatus(array_filter($formData->getApparatus()));
            $formData->setMeasures(array_filter($formData->getMeasures()));
            $this->em->persist($formData);
            $this->em->flush();

            switch (true) {
                case $form->get('saveAndPrevious')->isClicked():
                    return $this->redirectToRoute('Study-method', ['uuid' => $uuid]);
                case $form->get('saveAndNext')->isClicked():
                    return $this->redirectToRoute('Study-sample', ['uuid' => $uuid]);
                default:
                    if ($response = $this->_routeButtonClicks($form, $uuid)) {
                        return $response;
                    }
            }
        }

        return $this->render('Pages/Study/measure.html.twig', [
            'form' => $form->createView(),
            'experiment' => $experiment,
        ]);
    }

    /**
     * @Route("/{uuid}/method", name="method")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function methodAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::methodAction with [UUID: $uuid]");
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);

        if (!$this->_checkAccess($experiment)) {
            return $this->redirectToRoute('dashboard');
        }

        $form = $this->questionnaire->askAndHandle($experiment->getMethodMetaDataGroup(), 'save', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($experiment);
            $this->em->flush();

            switch (true) {
                case $form->get('saveAndPrevious')->isClicked():
                    return $this->redirectToRoute('Study-theory', ['uuid' => $uuid]);
                case $form->get('saveAndNext')->isClicked():
                    return $this->redirectToRoute('Study-measure', ['uuid' => $uuid]);
                default:
                    if ($response = $this->_routeButtonClicks($form, $uuid)) {
                        return $response;
                    }
            }
        }

        return $this->render('Pages/Study/method.html.twig', [
            'form' => $form->createView(),
            'experiment' => $experiment,
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
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);

        if (!$this->_checkAccess($experiment)) {
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('Pages/Study/materials.html.twig', [
            'experiment' => $experiment,
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
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);

        if (!$this->_checkAccess($experiment)) {
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('Pages/Study/datasets.html.twig', [
            'experiment' => $experiment,
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
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);

        if (!$this->_checkAccess($experiment)) {
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('Pages/Study/introduction.html.twig', [
            'experiment' => $experiment,
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
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);

        if (!$this->_checkAccess($experiment)) {
            return $this->redirectToRoute('dashboard');
        }

        $this->crud->deleteStudy($experiment);

        return $this->redirectToRoute('Study-overview');
    }


    /**
     * @param array|null $array
     * @return array|string[]
     */
    private function _prepareEmptyArray(?array $array): array
    {
        if (null === $array || 0 >= sizeof($array)) {
            $array = array("");
        }

        return $array;
    }


    /**
     * @param FormInterface $form
     * @param string $uuid
     * @return RedirectResponse|null
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    private function _routeButtonClicks(FormInterface $form, string $uuid): ?RedirectResponse
    {
        switch (true) {
            case $form->get('saveAndIntroduction')->isClicked():
                return $this->redirectToRoute('Study-introduction', ['uuid' => $uuid]);
            case $form->get('saveAndDocumentation')->isClicked():
                return $this->redirectToRoute('Study-documentation', ['uuid' => $uuid]);
            case $form->get('saveAndTheory')->isClicked():
                return $this->redirectToRoute('Study-theory', ['uuid' => $uuid]);
            case $form->get('saveAndMethod')->isClicked():
                return $this->redirectToRoute('Study-method', ['uuid' => $uuid]);
            case $form->get('saveAndMeasure')->isClicked():
                return $this->redirectToRoute('Study-measure', ['uuid' => $uuid]);
            case $form->get('saveAndSample')->isClicked():
                return $this->redirectToRoute('Study-sample', ['uuid' => $uuid]);
            case $form->get('saveAndDatasets')->isClicked():
                return $this->redirectToRoute('Study-datasets', ['uuid' => $uuid]);
            case $form->get('saveAndMaterials')->isClicked():
                return $this->redirectToRoute('Study-materials', ['uuid' => $uuid]);
            case $form->get('saveAndReview')->isClicked():
                return $this->redirectToRoute('Study-review', ['uuid' => $uuid]);
            case $form->get('saveAndExport')->isClicked():
                return $this->redirectToRoute('export_index', ['uuid' => $uuid]);
            case $form->get('saveAndSettings')->isClicked():
                return $this->redirectToRoute('Study-settings', ['uuid' => $uuid]);
        }

        return null;
    }

    private function _checkAccess(Experiment $experiment): bool
    {
        return $this->isGranted(UserRoles::ADMINISTRATOR) || $experiment->getOwner() === $this->getUser();
    }
}
