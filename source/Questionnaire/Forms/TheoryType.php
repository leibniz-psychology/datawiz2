<?php


namespace App\Questionnaire\Forms;


use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\BasicInformationMetaDataGroup;
use App\Domain\Model\Study\TheoryMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TheoryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MetaDataDictionary::SHORTNAME, TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TheoryMetaDataGroup::class,
        ]);
    }
}