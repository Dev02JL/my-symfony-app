<?php
namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(UserRepository $userRepository, ArticleRepository $articleRepository): Response
    {
        $users = [];
        $currentUser = $this->getUser();

        if ($currentUser && $currentUser->getUsername() === 'root') {
            $users = $userRepository->findAll();
        }

        $latestArticles = $articleRepository->findBy([], ['createdAt' => 'DESC'], 3);

        return $this->render('home/index.html.twig', [
            'users' => $users,
            'latestArticles' => $latestArticles,
        ]);
    }
}