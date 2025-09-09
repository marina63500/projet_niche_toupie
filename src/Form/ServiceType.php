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
                'required' => true,
                // 'mapped' => false, // pour gérer l'upload moi meme,ne lie pas direct a l'entité
            //     'constraints' => [
            //         new File([
            //             'maxSize' => '1024k',
            //             'mimeTypes' => [
            //                 'image/jpeg',
            //                 'image/png',
            //                 'image/jpg',
            //                 'image/webp',
            //             ],
            //             'mimeTypesMessage' => 'Please upload a valid image (JPEG , PNG, JPG, WEBP)',
            //         ])
            //     ],
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Description du service',
                'required' => true,
                'attr' => ['rows' => 10,
                            'cols' => 20,
                          ] // Définit le nombre de colonnes visibles dans le textarea
            ])
            
            ->add('price', MoneyType::class, [
                'label' => 'Prix du service',
                'required' => true,
            ])

            ->add('ImageHeader', FileType::class, [
                'label' => 'Image bannière du service',
                'required' => true,
                // 'mapped' => false,
                // 'constraints' => [
                //     new File([
                //         'maxSize' => '1024k',
                //         'mimeTypes' => [
                //             'image/jpeg',
                //             'image/png',
                //             'image/jpg',
                //             'image/webp',
                //         ],
                //         'mimeTypesMessage' => 'Please upload a valid image (JPEG , PNG, JPG, WEBP)',
                //     ])
                // ],
            ])
            
            ->add('paragraph', TextareaType::class, [
                'label' => 'Détails du service',
                'required' => true,
                'attr' => ['rows' => 10,
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
