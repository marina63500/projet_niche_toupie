<?php

namespace App\Form;

use App\Entity\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AdminContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder          
        
         
            ->add('status', ChoiceType::class, [
                'label' => 'Statut du message',
                'choices' => [
                    'Traité' => 'true', //checkbox
                    'Non traité' => 'false', // traite l'info ici pas besoin  dans controller
                   
                ],
                'expanded' => true, //boutons radio
                'multiple' => false,
                'attr' => [                    
                    'style' => 'background-color: rgba(135, 169, 34, 0.2);
                               border: 2px solid #114232;
                               border-radius: 5px;
                               padding: 10px;',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
