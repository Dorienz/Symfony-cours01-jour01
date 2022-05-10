<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArticleRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }


    /**
     * @Route("/blog", name="blog")
     */
    public function blog(ArticleRepository $articleRepository): Response
    {
        $articles =  $articleRepository->findAll();
        return $this->render('blog/blog.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/blog/new", name="blog_new")
     */
    public function blogNew(Request $request, EntityManagerInterface $entityManager): Response
    {

        $article = new Article();

        $form = $this->createForm(ArticleFormType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {

            $date = new DateTime();
            $date->format('Y-m-d H:i:s');
            $dateValable = clone $date;
            $dateValable->modify('+2 hour');
            $article->setCreatedAt($dateValable);

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('blog');
        }


        return $this->renderForm('blog/newArticle.html.twig', [
            'form' => $form,

        ]);
    }


    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function showblog(Article $article): Response
    {
        return $this->render('blog/showArticle.html.twig', [
            'article' => $article
        ]);
    }
}
