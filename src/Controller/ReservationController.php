<?php

namespace App\Controller;

use Dom\Entity;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\DogRepository;
use App\Repository\UserRepository;
use App\Enum\ReservationStatusEnum;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/reservation')]
final class ReservationController extends AbstractController
{
    // voir mes reservations
    #[Route('', name: 'index_list_reservation')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }


        $reservations = $entityManager->getRepository('App\Entity\Reservation')->findBy([
            'user' => $user
        ], [
            'reservationDate' => 'DESC'
        ]);

        return $this->render('reservation/index.html.twig', [           
            'reservations' => $reservations,
        ]);
    }

    // créer une  réservation pour un service
    #[Route('/create/service/{id}', name: 'reservation_create')]
    public function create(int $id, ServiceRepository $serviceRepository, DogRepository $dogRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour créer une réservation.');
            return $this->redirectToRoute('app_login');
        }
        // Récupérer les chiens de l'utilisateur
        $userDogs = $dogRepository->findBy(['user' => $user]);
        
      

        $reservation = new Reservation();
       

        // On passe les chiens disponibles au formulaire via une option
        $form = $this->createForm(ReservationType::class, $reservation, [
            'user_dogs' => $userDogs,
        ]);
       

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $reservation->setUser($user);
            $reservation->setService($serviceRepository->find($id));   
            $reservation->setCreatedAt(new \DateTime());
            // $reservation->setHistorical([
            //     'createdAt' => new \DateTime(),
            //     'createdBy' => $user,
            //     'status' => 'En attente'
            // ]);
            $reservation->setPrice($reservation->getService()->getPrice());
            $reservation->setStatus(ReservationStatusEnum::PENDING); // voir enum

            $entityManager->persist($reservation);
            $entityManager->flush();

            $this->addFlash('success', 'Votre réservation a été crée avec succès.');

            return $this->redirectToRoute('index_list_reservation');
        }

        return $this->render('reservation/create.html.twig', [
            'form' => $form->createView(),
            'reservation' => $reservation,
            'service' => $reservation->getService(),
            
        ]);
    }

    // annuler une réservation
    #[Route('/cancel/{id}', name: 'reservation_cancel')]
    public function cancel($id, ReservationRepository $reservationRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {         
            $this->addFlash('error', 'Vous devez être connecté pour annuler une réservation.');
            return $this->redirectToRoute('app_login');  
        }
        

        $reservation = $reservationRepository->find($id);
    
        if (!$reservation) {
            throw $this->createNotFoundException('Réservation non trouvée');
        }
        // je recupere le statue et Changer le statut en "annulée"
        $reservation->setStatus(ReservationStatusEnum::CANCELED);
        $entityManager->persist($reservation);

       
        $entityManager->flush();

        $this->addFlash('success', 'Votre réservation a été annulée avec succès.');

        return $this->redirectToRoute('index_list_reservation');
    }
}