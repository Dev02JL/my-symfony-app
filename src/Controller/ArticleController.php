<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article/create', name: 'create_article')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de l'upload de l'image
            $imageFile = $form['imagePath']->getData();
            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $article->setImagePath('/images/' . $newFilename);
            }

            $article->setCreatedAt(new \DateTime());
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('list_articles');
        }

        return $this->render('article/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/article', name: 'list_articles')]
    public function index(EntityManagerInterface $em): Response
    {
        $articles = $em->getRepository(Article::class)->findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{id}', name: 'show_article')]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $article = $em->getRepository(Article::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Article non trouvé');
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/article/delete/{id}', name: 'delete_article')]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $article = $em->getRepository(Article::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Article non trouvé');
        }

        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('list_articles');
    }
}