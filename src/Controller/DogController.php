<?php

namespace App\Controller;

use App\Entity\Dog;

use App\Form\DogType;
use App\Repository\DogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/dog')]
final class DogController extends AbstractController
{
    //ajouter un chien
    #[Route('/add', name: 'dog_add')]
    public function add(Request $request, EntityManagerInterface $entityManager, DogRepository  $dogRepository): Response
    {
        // recuperation du user connecté
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $dog = new Dog();

        $form = $this->createForm(DogType::class, $dog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dog->setUser($user);

            $entityManager->persist($dog);
            $entityManager->flush();

            $this->addFlash('success', 'Chien ajouté avec succès.');

            return $this->redirectToRoute('profile_edit');
        }

        return $this->render('dog/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //supprimer un chien
    #[Route('/delete/{id}', name: 'dog_delete')]
    public function delete(int $id, DogRepository $dogRepository, EntityManagerInterface $entityManager): Response
    {
        $dog = $dogRepository->find($id);

        if (!$dog) {
            throw $this->createNotFoundException('Dog not found');
        }

        // Vérifier si le chien appartient à l'utilisateur connecté
        $user = $this->getUser();
        if ($dog->getUser() !== $user) {
            throw $this->createAccessDeniedException('You do not have permission to delete this dog');
        }
        
        
        $entityManager->remove($dog);
        $entityManager->flush();

        $this->addFlash('success', 'Chien supprimé avec succès.');

        return $this->redirectToRoute('profile_edit');
    }
}
