<?php

namespace App\Form;

use App\Domain\Definition\MetaDataDictionary;
use App\Entity\FileManagement\AdditionalMaterial;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileDescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MetaDataDictionary::FILE_DESCRIPTION, TextareaType::class, [
                'required' => false,
                // 'label' => 'Objective',
                'label' => 'Describe the content of the file.',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdditionalMaterial::class,
        ]);
    }
}
