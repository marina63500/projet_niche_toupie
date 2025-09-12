<?php

namespace App\Controller;

use Dom\Entity;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/contact')]
final class ContactController extends AbstractController
{
    //demande de contact
    #[Route('/create', name: 'app_contact_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        // un user non connecté peut envoyer un message
        $contact = new Contact();


        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $contact->setCreatedAt(new \DateTime());
            $contact->setStatus(false); // Statut false = (non traité)

            $entityManager->persist($contact);
            $entityManager->flush();

            $this->addFlash('success', 'Commentaire ajouté avec succès.');
            return $this->redirectToRoute('app_contact');
        }

            return $this->render('contact/create.html.twig', [
                'contact' => $contact,
                'form' => $form->createView(),
        ]);
    }

}
