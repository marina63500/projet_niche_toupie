<?php

namespace App\Controller\Admin;

use App\Form\AdminContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/contact')]
final class AdminContactController extends AbstractController
{
    #[Route('', name: 'admin_contact')]
    public function index(ContactRepository $contactRepository): Response
    {
        // Afficher la liste des messages de contacts
        $contacts = $contactRepository->findAll();

        $contacts = $contactRepository->findby([], ['createdAt' => 'DESC']);

        return $this->render('admin_contact/index.html.twig', [

            'contacts' => $contacts,
        ]);
    }

    //route pour modifier le status d'un contact
    #[Route('/edit/{id}', name: 'admin_contact_edit')]
    public function changeStatus(int $id, ContactRepository $contactRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        //je recupere le contact
        $contact = $contactRepository->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact not found');
        }

        $form = $this->createForm(AdminContactType::class, $contact);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            //je recupere le status actuel,pas de get car boolean     
            // $status = $contact->isStatus();

            // if (!$status) {          //pour un boolean on utilise ! pour inverser la valeur
            //     $contact->setStatus(true);
            // } else {
            //     $contact->setStatus(false);
            // }

            $entityManager->persist($contact);
            $entityManager->flush();

            $this->addFlash('success', 'Le statut a été mis à jour avec succès.');

            return $this->redirectToRoute('admin_contact');
        }


        return $this->render('admin_contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }
}
