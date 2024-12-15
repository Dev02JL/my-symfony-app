<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/delete/{id}', name: 'delete_user', methods: ['POST'])]
    public function delete(User $user, EntityManagerInterface $entityManager): Response
    {
        if ($user->getUsername() === 'root') {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer l’utilisateur root.');
            return $this->redirectToRoute('home');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Utilisateur supprimé avec succès.');

        return $this->redirectToRoute('home');
    }
}