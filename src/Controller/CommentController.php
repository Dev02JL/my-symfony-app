<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/article/{id}/comment', name: 'add_comment', methods: ['POST'])]
    public function addComment(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérifie si l'utilisateur est connecté
        if (!$this->getUser()) {
            $this->addFlash('error', 'Vous devez être connecté pour ajouter un commentaire.');
            return $this->redirectToRoute('app_login');
        }

        $content = $request->request->get('content');

        if ($content) {
            $comment = new Comment();
            $comment->setContent($content);
            $comment->setCreatedAt(new \DateTime());
            $comment->setArticle($article);
            $comment->setUser($this->getUser());

            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Commentaire ajouté avec succès.');
        }

        return $this->redirectToRoute('show_article', ['id' => $article->getId()]);
    }

    #[Route('/comment/delete/{id}', name: 'delete_comment', methods: ['POST'])]
    public function deleteComment(Comment $comment, EntityManagerInterface $entityManager, Request $request): Response
    {
        // Vérifie que l'utilisateur connecté est bien l'auteur du commentaire
        if ($comment->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez supprimer que vos propres commentaires.');
            return $this->redirectToRoute('show_article', ['id' => $comment->getArticle()->getId()]);
        }

        // Supprime le commentaire
        $entityManager->remove($comment);
        $entityManager->flush();

        $this->addFlash('success', 'Commentaire supprimé avec succès.');

        return $this->redirectToRoute('show_article', ['id' => $comment->getArticle()->getId()]);
    }
}