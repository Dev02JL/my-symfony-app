<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VolleyController extends AbstractController
{
    #[Route('/volley', name: 'volley')]
    public function index(): Response
    {
        return $this->render('volley/index.html.twig');
    }
}