<?php
/**
 * This class represent a metadata questionaire within DataWiz
 * means one entire form page within the application.
 */

namespace App\Questionnaire\Forms;

use App\Domain\Model\Study\BasicInformationMetaDataGroup;
use App\Domain\Model\Study\SettingsMetaDataGroup;
use App\Questionnaire\Fields\ShortNameSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudySettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('shortName', TextType::class)
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SettingsMetaDataGroup::class,
        ]);
    }
}
