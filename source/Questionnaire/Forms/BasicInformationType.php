<?php


namespace App\Questionnaire\Forms;


use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\BasicInformationMetaDataGroup;
use App\Domain\Model\Study\SettingsMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BasicInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
            ->add(MetaDataDictionary::CREATOR, TextType::class)
            ->add(MetaDataDictionary::CONTACT, TextareaType::class)
            ->add(MetaDataDictionary::TITLE, TextareaType::class)
            ->add(MetaDataDictionary::DESCRIPTION, TextareaType::class)
            ->add(MetaDataDictionary::RELATED_PUBS, TextareaType::class)
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BasicInformationMetaDataGroup::class,
        ]);
    }
}