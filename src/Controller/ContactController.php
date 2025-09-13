<?php

namespace App\Controller;

use Dom\Entity;
use DateTimeImmutable;
use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


final class ContactController extends AbstractController{
    //demande de contact
    #[Route('/contact/create', name: 'contact_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        // un user non connecté peut envoyer un message
        $contact = new Contact();


        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $contact->setCreatedAt(new \DateTime());
            $contact->setStatus(false); // Statut false = (non traité) par défaut

            $entityManager->persist($contact);
            $entityManager->flush();

            $this->addFlash('success', 'demande de contact envoyée avec succès.');

            return $this->redirectToRoute('app_home');
        }

            return $this->render('contact/create.html.twig', [
                'form' => $form->createView(),
                'contact' => $contact,
               
        ]);
    }

}
