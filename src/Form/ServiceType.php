<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title du service',
                'attr' => ['placeholder' => 'Entrez le titre du service'],
                'required' => true,
            ])

            ->add('image', FileType::class, [
                'label' => 'Image du service',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file (JPEG, PNG, GIF, WEBP)',
                    ])
                ],

            ])

            ->add('description', TextareaType::class, [
                'label' => 'Description du service',
                'required' => true,
                'attr' => [
                    'rows' => 10,
                    'cols' => 20,
                ]
            ])

            ->add('price', MoneyType::class, [
                'label' => 'Prix du service',
                'required' => true,
            ])

            ->add('ImageHeader', FileType::class, [
                'label' => 'Image bannière du service',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file (JPEG, PNG, GIF, WEBP)',
                    ])
                ],

            ])

            ->add('paragraph', TextareaType::class, [
                'label' => 'Détails du service',
                'required' => true,
                'attr' => [
                    'rows' => 10,
                    'cols' => 30,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
