<?php

/**
 * This class represent a metadata questionaire within DataWiz
 * means one entire form page within the application.
 */

namespace App\Form;

use App\Entity\Constant\MetaDataDictionary;
use App\Entity\Study\SettingsMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MetaDataDictionary::SHORTNAME, TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SettingsMetaDataGroup::class,
        ]);
    }
}
