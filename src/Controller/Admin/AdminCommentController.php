<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin/comment')]
final class AdminCommentController extends AbstractController
{
    // tous les commentaires pour l'admin
    #[Route('', name: 'index_admin_comment')]
    public function index(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findAll();
        // tri par date décroissante
         $comments = $commentRepository->findBy([], ['createdAt' => 'DESC']);
      
        return $this->render('admin_comment/index.html.twig', [
            
            'comments' => $comments,
        ]);
    }

//    supprimer un commentaire
    #[Route('/delete/{id}', name: 'admin_comment_delete')]
    public function delete($id, CommentRepository $commentRepository, EntityManagerInterface $em): Response
    {
        $comment = $commentRepository->find($id);
        if (!$comment) {
            throw $this->createNotFoundException('Commentaire non trouvé');
        }

        $em->remove($comment);
        $em->flush();

        $this->addFlash('success', 'Le commentaire a bien été supprimé');

        return $this->redirectToRoute('index_admin_comment');
    }

}
