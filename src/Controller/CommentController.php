<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/comment')]
final class CommentController extends AbstractController
{
    // Liste des commentaires
    #[Route('', name: 'app_comment')]
    public function index(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findAll();
      
        return $this->render('comment/index.html.twig', [            
            'comments' => $comments,
        ]);
    }

    // Ajouter un commentaire
   #[Route('/add', name: 'comment_add')]
    public function new( EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser(); 

        if ($user === null) {
            // L'utilisateur n'est pas connecté, rediriger vers la page de connexion
            return $this->redirectToRoute('app_login');
        }

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUser($user); // Associer le commentaire à l'utilisateur connecté

            // $comment->setCreatedAt(new \DateTime()); // Définir la date de création

            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Commentaire ajouté avec succès.');

            return $this->redirectToRoute('app_comment');
        }
      
        return $this->render('comment/addComment.html.twig',[
            'form' => $form->createView(),
            'comment' => $comment,
        ]);
    }

    // Supprimer un commentaire
    #[Route('/delete/{id}', name: 'comment_delete')]
    public function delete($id, CommentRepository $commentRepository, EntityManagerInterface $entityManager): Response
    {
        $comment = $commentRepository->find($id);
       if (!$comment) {
           $this->addFlash('error', 'Commentaire non trouvé.');
           return $this->redirectToRoute('app_comment');
       }

        $user = $this->getUser();

        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour supprimer un commentaire.');
            return $this->redirectToRoute('app_login');
        }

        // Vérifier si l'utilisateur est bien l'auteur du commentaire
        if ($comment->getUser() !== $user) {
            $this->addFlash('error', 'Vous ne pouvez supprimer que vos propres commentaires.');
            return $this->redirectToRoute('app_comment');
        }

        
            $entityManager->remove($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Commentaire supprimé avec succès.');
        

        return $this->redirectToRoute('app_service_show', ['id' => $comment->getService()->getId()]);

    }


   
}