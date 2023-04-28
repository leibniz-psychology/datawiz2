<?php

namespace App\View\Controller;

use App\Crud\Crudable;
use App\Domain\Definition\States;
use App\Domain\Definition\UserRoles;
use App\Domain\Model\Administration\DataWizUser;
use App\Domain\Model\Study\CreatorMetaDataGroup;
use App\Domain\Model\Study\Experiment;
use App\Questionnaire\Questionnairable;
use DateTime;
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
    public function __construct(private readonly Security $security, private readonly Questionnairable $questionnaire, private readonly EntityManagerInterface $em, private readonly LoggerInterface $logger, private readonly Crudable $crud)
    {
    }


    /**
     * @Route("/", name="overview")
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
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function newAction(Questionnairable $questionnaire, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::newAction");
        $newExperiment = Experiment::createNewExperiment($this->em->getRepository(DataWizUser::class)->find($this->security->getUser()));
        $form = $questionnaire->askAndHandle($newExperiment->getSettingsMetaDataGroup(), 'create', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $newExperiment->setDateCreated(new DateTime());
            $newExperiment->setDateSubmitted(null);
            $newExperiment->setState(States::STATE_STUDY_NONE);
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

    private function _prepareEmptyArray(?array $array): array
    {
        if (null === $array || 0 >= sizeof($array)) {
            $array = [""];
        }

        return $array;
    }


    /**
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    private function _routeButtonClicks(FormInterface $form, string $uuid): ?RedirectResponse
    {
        return match (true) {
            $form->get('saveAndIntroduction')->isClicked() => $this->redirectToRoute('Study-introduction', ['uuid' => $uuid]),
            $form->get('saveAndDocumentation')->isClicked() => $this->redirectToRoute('Study-documentation', ['uuid' => $uuid]),
            $form->get('saveAndTheory')->isClicked() => $this->redirectToRoute('Study-theory', ['uuid' => $uuid]),
            $form->get('saveAndMethod')->isClicked() => $this->redirectToRoute('Study-method', ['uuid' => $uuid]),
            $form->get('saveAndMeasure')->isClicked() => $this->redirectToRoute('Study-measure', ['uuid' => $uuid]),
            $form->get('saveAndSample')->isClicked() => $this->redirectToRoute('Study-sample', ['uuid' => $uuid]),
            $form->get('saveAndDatasets')->isClicked() => $this->redirectToRoute('Study-datasets', ['uuid' => $uuid]),
            $form->get('saveAndMaterials')->isClicked() => $this->redirectToRoute('Study-materials', ['uuid' => $uuid]),
            $form->get('saveAndReview')->isClicked() => $this->redirectToRoute('Study-review', ['uuid' => $uuid]),
            $form->get('saveAndExport')->isClicked() => $this->redirectToRoute('export_index', ['uuid' => $uuid]),
            $form->get('saveAndSettings')->isClicked() => $this->redirectToRoute('Study-settings', ['uuid' => $uuid]),
            default => null,
        };
    }

    private function _checkAccess(Experiment $experiment): bool
    {
        return $this->isGranted(UserRoles::ADMINISTRATOR) || $experiment->getOwner() === $this->getUser();
    }
}
