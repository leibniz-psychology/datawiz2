<?php

namespace App\Controller;

use App\Entity\Administration\DataWizUser;
use App\Entity\Constant\States;
use App\Entity\Study\CreatorMetaDataGroup;
use App\Entity\Study\Experiment;
use App\Service\Crud\Crudable;
use App\Service\Questionnaire\Questionnairable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/studies', name: 'Study-')]
#[IsGranted('ROLE_USER')]
class StudyController extends AbstractController
{
    public function __construct(
        private readonly Security $security,
        private readonly Questionnairable $questionnaire,
        private readonly EntityManagerInterface $em,
        private readonly LoggerInterface $logger,
        private readonly Crudable $crud
    ) {}

    #[Route(path: '/', name: 'overview', methods: ['GET'])]
    public function overview(): Response
    {
        $this->logger->debug('Enter StudyController::overviewAction');

        return $this->render('pages/study/overview.html.twig', [
            'all_experiments' => $this->em->getRepository(Experiment::class)->findBy(['owner' => $this->getUser()]),
        ]);
    }

    #[Route(path: '/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Questionnairable $questionnaire, Request $request): Response
    {
        $this->logger->debug('Enter StudyController::newAction');
        $newExperiment = Experiment::createNewExperiment($this->em->getRepository(DataWizUser::class)->find($this->security->getUser()));
        $form = $questionnaire->askAndHandle($newExperiment->getSettingsMetaDataGroup(), 'create', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $newExperiment->setDateCreated(new \DateTime());
            $newExperiment->setDateSubmitted(null);
            $newExperiment->setState(States::STATE_STUDY_NONE);
            $this->em->persist($newExperiment);
            $this->em->flush();

            return $this->redirectToRoute('Study-introduction', ['id' => $newExperiment->getId()]);
        }

        return $this->render('pages/study/new.html.twig', [
            'form' => $form,
            'experiment' => $newExperiment,
        ]);
    }

    #[Route(path: '/{id}/settings', name: 'settings', methods: ['GET'])]
    public function settings(Experiment $experiment, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::settingsAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        $form = $this->questionnaire->askAndHandle($experiment->getSettingsMetaDataGroup(), 'save', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($experiment);
            $this->em->flush();
        }

        return $this->render('pages/study/settings.html.twig', [
            'form' => $form,
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/documentation', name: 'documentation', methods: ['GET', 'POST'])]
    public function documentation(Experiment $experiment, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::documentationAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        $basicInformation = $experiment->getBasicInformationMetaDataGroup();
        if (sizeof($basicInformation->getCreators()) == 0) {
            $basicInformation->getCreators()->add(new CreatorMetaDataGroup());
        }
        $basicInformation->setRelatedPublications($this->_prepareEmptyArray($basicInformation->getRelatedPublications()));
        $form = $this->questionnaire->askAndHandle($basicInformation, 'save', $request);

        if (!$this->questionnaire->isSubmittedAndValid($form)) {
            return $this->render('pages/study/documentation.html.twig', [
                'form' => $form,
                'experiment' => $experiment,
            ]);
        }

        $formData = $form->getData();
        $currentCreators = $this->em->getRepository(CreatorMetaDataGroup::class)->findBy(['basicInformation' => $basicInformation]);

        foreach ($currentCreators as $currentCreator) {
            $this->em->remove($currentCreator);
        }

        $newCreators = $formData->getCreators();
        if (!$form->getData()->getCreators() instanceof Collection) {
            throw new \Error('Creators is not a collection');
        }
        if (is_iterable($newCreators)) {
            foreach ($newCreators as $creator) {
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

        $navigationResponse = $this->handleNavigation($form, $experiment->getId(), null, 'Study-theory');
        if ($navigationResponse !== null) {
            return $navigationResponse;
        }

        return $this->redirectToRoute('Study-documentation', ['id' => $experiment->getId()]);
    }

    #[Route(path: '/{id}/theory', name: 'theory', methods: ['GET', 'POST'])]
    public function theory(Experiment $experiment, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::theoryAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        $form = $this->questionnaire->askAndHandle($experiment->getTheoryMetaDataGroup(), 'save', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($experiment);
            $this->em->flush();

            $navigationResponse = $this->handleNavigation($form, $experiment->getId(), 'Study-documentation', 'Study-method');
            if ($navigationResponse !== null) {
                return $navigationResponse;
            }
        }

        return $this->render('pages/study/theory.html.twig', [
            'form' => $form,
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/sample', name: 'sample', methods: ['GET', 'POST'])]
    public function sample(Experiment $experiment, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::sampleAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

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

            $navigationResponse = $this->handleNavigation($form, $experiment->getId(), 'Study-measure', null);
            if ($navigationResponse !== null) {
                return $navigationResponse;
            }
        }

        return $this->render('pages/study/sample.html.twig', [
            'form' => $form,
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/measure', name: 'measure', methods: ['GET', 'POST'])]
    public function measure(Experiment $experiment, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::measureAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        $experiment->getMeasureMetaDataGroup()->setMeasures($this->_prepareEmptyArray($experiment->getMeasureMetaDataGroup()->getMeasures()));
        $experiment->getMeasureMetaDataGroup()->setApparatus($this->_prepareEmptyArray($experiment->getMeasureMetaDataGroup()->getApparatus()));
        $form = $this->questionnaire->askAndHandle($experiment->getMeasureMetaDataGroup(), 'save', $request);
        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $formData = $form->getData();
            $formData->setApparatus(array_filter($formData->getApparatus()));
            $formData->setMeasures(array_filter($formData->getMeasures()));
            $this->em->persist($formData);
            $this->em->flush();

            $navigationResponse = $this->handleNavigation($form, $experiment->getId(), 'Study-method', 'Study-sample');
            if ($navigationResponse !== null) {
                return $navigationResponse;
            }
        }

        return $this->render('pages/study/measure.html.twig', [
            'form' => $form,
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/method', name: 'method', methods: ['GET', 'POST'])]
    public function method(Experiment $experiment, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::methodAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        $form = $this->questionnaire->askAndHandle($experiment->getMethodMetaDataGroup(), 'save', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($experiment);
            $this->em->flush();

            $navigationResponse = $this->handleNavigation($form, $experiment->getId(), 'Study-theory', 'Study-measure');
            if ($navigationResponse !== null) {
                return $navigationResponse;
            }
        }

        return $this->render('pages/study/method.html.twig', [
            'form' => $form,
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/materials', name: 'materials', methods: ['GET'])]
    public function materials(Experiment $experiment): Response
    {
        $this->logger->debug("Enter StudyController::materialsAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        return $this->render('pages/study/materials.html.twig', [
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/datasets', name: 'datasets', methods: ['GET'])]
    public function datasets(Experiment $experiment): Response
    {
        $this->logger->debug("Enter StudyController::datasetsAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        return $this->render('pages/study/datasets.html.twig', [
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/introduction', name: 'introduction', methods: ['GET'])]
    public function introduction(Experiment $experiment): Response
    {
        $this->logger->debug("Enter StudyController::introductionAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        return $this->render('pages/study/introduction.html.twig', [
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/delete', name: 'delete', methods: ['GET'])]
    public function delete(Experiment $experiment): Response
    {
        $this->logger->debug("Enter StudyController::deleteAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        $this->crud->deleteStudy($experiment);

        return $this->redirectToRoute('Study-overview');
    }

    private function _prepareEmptyArray(?array $array): array
    {
        if ($array === null || sizeof($array) <= 0) {
            $array = [''];
        }

        return $array;
    }

    private function _routeButtonClicks(FormInterface $form, string $id): ?RedirectResponse
    {
        $sections = [
            ['saveAndIntroduction', 'Study-introduction'],
            ['saveAndDocumentation', 'Study-documentation'],
            ['saveAndTheory', 'Study-theory'],
            ['saveAndMethod', 'Study-method'],
            ['saveAndMeasure', 'Study-measure'],
            ['saveAndSample', 'Study-sample'],
            ['saveAndDatasets', 'Study-datasets'],
            ['saveAndMaterials', 'Study-materials'],
            ['saveAndReview', 'Study-review'],
            ['saveAndExport', 'export_index'],
            ['saveAndSettings', 'Study-settings'],
        ];

        foreach ($sections as $section) {
            $navigationButton = $form->get($section[0]);
            if (!$navigationButton instanceof SubmitButton) {
                throw new \Error("Navigation button {$section[0]} is not a SubmitButton");
            }
            if ($navigationButton->isClicked()) {
                return $this->redirectToRoute($section[1], ['id' => $id]);
            }
        }

        return null;
    }

    private function handleNavigation(FormInterface $form, string $id, ?string $prev, ?string $next): ?RedirectResponse
    {
        if ($prev !== null) {
            $prevButton = $form->get('saveAndPrevious');
            if (!$prevButton instanceof SubmitButton) {
                throw new \Error('Cannot find "previous" navigation button');
            }
            if ($prevButton->isClicked()) {
                return $this->redirectToRoute($prev, ['id' => $id]);
            }
        }

        if ($next !== null) {
            $nextButton = $form->get('saveAndNext');
            if (!$nextButton instanceof SubmitButton) {
                throw new \Error('Cannot find "next" navigation button');
            }
            if ($nextButton->isClicked()) {
                return $this->redirectToRoute($next, ['id' => $id]);
            }
        }

        if ($response = $this->_routeButtonClicks($form, $id)) {
            return $response;
        }

        return null;
    }
}
