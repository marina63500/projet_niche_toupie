<?php

namespace App\Form;

use BcMath\Number;
use App\Entity\Dog;
use App\Entity\User;
use App\Entity\Service;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reservationDate', DateTimeType::class, [
                'label' => 'Date de la réservation',
                'widget' => 'single_text',                
                'html5' => true,// calendrier
                'required' => true, 
            ])

           
              ->add('dog', EntityType::class, [
                'class' => Dog::class,
                'choices' => $options['user_dogs'], // Utiliser les chiens passés en option dans le controller
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez votre chien',
                // 'multiple' => true, // pour sélectionner un chien => true pour plusieurs
                'expanded' => true, // pour des cases à cocher                
                'required' => true,
            ])

            //gerer dans controller car en json
            // ->add('historical', json_encode([]), [
            //     'label' => 'Historique',
            //     'required' => false,
            // ])

            // gérer  dans le controller car le user ne choisit pas

            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])

           
            // ->add('service', EntityType::class, [
            //     'class' => Service::class,
            //     'choice_label' => 'nom du service',
            // ])

            // ->add('createdAt')

            // ->add('price',MoneyType::class, [
            //     'label' => 'Prix de la réservation',
            //     'currency' => 'EUR',
            //     'required' => true,
            // ])

            //  ->add('status',ChoiceType::class, [
            //     'label' => 'Statut',
            //     'choices' => [
            //         'En attente' => 100,
            //         'Confirmée' => 200,
            //         'Annulée' => 300,
            //     ],
            //     'required' => true,
            // ])

          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'user_dogs' => [], // Option pour passer les chiens de l'utilisateur
        ]);
    }
}
