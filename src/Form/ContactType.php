<?php

namespace App\Form;

use DateTime;
use Dom\Text;
use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class, [
                'label' => 'Votre adresse email',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez votre adresse email',
                    'style' => 'background-color: rgba(135, 169, 34, 0.2);
                                border: 2px solid #114232;',
                ]
            ])
            ->add('subject', TextType::class, [
                'label' => 'Sujet',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez le sujet',
                    'style' => 'background-color: rgba(135, 169, 34, 0.2);
                                border: 2px solid #114232;',
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Message',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez votre message',
                    'style' => 'background-color: rgba(135, 169, 34, 0.2);
                                border: 2px solid #114232;',
                    'rows' => 10,
                    'cols' => 20
                ]
             
            ])

            //gerer dans le controller

            // ->add('createdAt', DateTimeType::class, [
            //     'label' => 'Date de création'
            // ])
            // ->add('status', CheckboxType::class, [
            //     'label' => 'Statut'
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
