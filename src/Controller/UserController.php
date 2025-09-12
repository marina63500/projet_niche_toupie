<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\DogRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UserController extends AbstractController
{
    #[Route('/profile', name: 'profile_edit')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, DogRepository $dogRepository): Response
    {
        // recuperation du user connecté
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        //recuperation des chiens du user connecté
        $userdogs =  $dogRepository->findBy(['user' => $user]);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($user); 
            $entityManager->flush();

            $this->addFlash('success', 'Profil mis à jour .');

            return $this->redirectToRoute('profile_edit');
        }


        return $this->render('user/profile_edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'dogs' => $userdogs,
        ]);
        
       
    }
}
