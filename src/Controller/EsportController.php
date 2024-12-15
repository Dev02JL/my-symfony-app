<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EsportController extends AbstractController
{
    #[Route('/esport', name: 'esport')]
    public function index(): Response
    {
        return $this->render('esport/index.html.twig');
    }
}