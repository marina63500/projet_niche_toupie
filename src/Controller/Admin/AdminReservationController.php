<?php

namespace App\Controller\Admin;


use App\Form\AdminReservationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Gestion des réservations côté admin
#[Route('/admin/reservation')]
final class AdminReservationController extends AbstractController
{// voir toutes les réservations
    #[Route('', name: 'admin_reservation_index')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();
        // tri par date décroissante
        $reservations = $reservationRepository->findBy([], ['reservationDate' => 'DESC']);

        return $this->render('admin_reservation/index.html.twig', [
           
            'reservations' => $reservations,
        ]);
    }
// voir le détail d'une réservation
    #[Route('/show/{id}', name: 'admin_reservation_show')]
    public function show($id, ReservationRepository $reservationRepository): Response
    {
        $reservation = $reservationRepository->find($id);       

        if (!$reservation) {
            throw $this->createNotFoundException('Réservation non trouvée');
        }



        return $this->render('admin_reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }
// modifier une réservation
    #[Route('/edit/{id}', name: 'admin_reservation_edit')]
    public function edit($id, ReservationRepository $reservationRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $reservation = $reservationRepository->find($id);

        if (!$reservation) {
            throw $this->createNotFoundException('Réservation non trouvée');
        }
        //recupere le status
        $status = $reservation->getStatus(); 

        $form = $this->createForm(AdminReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            $this->addFlash('success', 'Réservation modifiée avec succès.');

            return $this->redirectToRoute('admin_reservation_index');
        }

        return $this->render('admin_reservation/edit.html.twig', [
            'form' => $form->createView(),
            'reservation' => $reservation,
            'status' => $status,
        ]);
    }
        }



  
