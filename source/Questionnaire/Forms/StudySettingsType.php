<?php
/**
 * This class represent a metadata questionaire within DataWiz
 * means one entire form page within the application.
 */

namespace App\Questionnaire\Forms;

use App\Domain\Model\StudySettingsMetaDataGroup;
use App\Questionnaire\Fields\ShortNameSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudySettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventSubscriber(new ShortNameSubscriber())
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StudySettingsMetaDataGroup::class,
        ]);
    }
}
