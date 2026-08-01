<?php

declare(strict_types=1);

namespace App\Form\Project;

use App\Entity\Project\Project;
use App\Entity\Study\Experiment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectStudiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('experiments', EntityType::class, [
            'class' => Experiment::class,
            'choices' => $options['experiment_choices'],
            'multiple' => true,
            'expanded' => true,
            'by_reference' => false,
            'required' => false,
            'label' => 'project.studies.list.label',
            'choice_label' => fn (Experiment $experiment) => $experiment->getSettingsMetaDataGroup()->getShortName()
                ?? $experiment->getBasicInformationMetaDataGroup()->getTitle()
                ?? (string) $experiment->getId(),
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
            'translation_domain' => 'forms',
            'experiment_choices' => [],
        ]);
        $resolver->setAllowedTypes('experiment_choices', 'array');
    }
}
