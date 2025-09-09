<?php

namespace App\Controller;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



#[Route('/service')]
final class ServiceController extends AbstractController
{
    // routes de tous les services
    #[Route('', name: 'app_service')]
    public function index(ServiceRepository $serviceRepository): Response
    {

        $services = $serviceRepository->findAll();

        return $this->render('service/index.html.twig', [
            'services' => $services
        ]);
    }

    // route d'un service en particulier
    #[Route('/show/{id}', name: 'app_service_show')]
    public function show(int $id, ServiceRepository $serviceRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $service = $serviceRepository->find($id);

        $comment = new Comment();
        $comment->setService($service); // Associe le commentaire au service
        $comment->setCreatedAt(new \DateTime()); // Définit la date de création

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setUser($this->getUser()); // Associe l'utilisateur connecté au commentaire
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Commentaire ajouté avec succès.');
            
            return $this->redirectToRoute('app_service_show', ['id' => $service->getId()]);
        }

        if (!$service) {
            throw $this->createNotFoundException('Service not found');
        }

        return $this->render('service/show.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
            'comment' => $comment,
        ]);
    }
}
