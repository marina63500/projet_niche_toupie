<?php

namespace App\Form;

use DateTime;
use App\Entity\Dog;
use App\Entity\User;
use App\Entity\Service;
use App\Entity\Reservation;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdminReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


            ->add('reservationDate', DateTimeType::class,[
                'label' => 'Date de la réservation',
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'En attente' => '100',
                    'Confirmée' => '200',
                    'Annulée' => '300',
                ],
                'expanded' => true,  //si true : boutons radio, si false : liste déroulante
                'multiple' => false, //si true : cases à cocher, si false :  radio ou liste déroulante
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
