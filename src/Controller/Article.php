<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Comments;
use App\Repository\ArticlesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Article extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function Home(ArticlesRepository $articlesRepository)
    {
        return $this->render("home.html.twig", [
            "title" => "Home",
            "articles" => $articlesRepository->findAll()
        ]);
    }


    /**
     * @Route("/login", name="login")
     */
    public function Login()
    {
        return $this->render("login.html.twig", [
            "title" => "Login"
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function Logout()
    {
    }

    /**
     * @Route("OneArticle/{id}", name="OneArticle", methods={"GET", "POST"})
     */
    public function OneArticle(Articles $articles, Request $request, ObjectManager $manager)
    {
        $comment = new Comments();

        $date = date("d-m-Y H:i:s");

        $users = $this->getUser();
        $users->getId();

        $form = $this->createFormBuilder($comment)
            ->add("content", TextareaType::class)
            ->add("Send", SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setActive(0);
            $comment->setDate($date);
            $comment->setUsersId($users);
            $manager->persist($comment);
            $manager->flush();

            $this->redirectToRoute('home');
        }
        return $this->render("article.html.twig", [
            'title' => "OneArticle",
            "article" => $articles,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("AddArticle", name="AddArticle")
     */
    public function AddArticles(ObjectManager $manager, Request $request)
    {
        $article = new Articles();

        $users = $this->getUser();
        $users->getId();

        $date = date("d-m-Y H:i:s");

        $form = $this->createFormBuilder($article)
            ->add("title", TextType::class)
            ->add("photo", UrlType::class)
            ->add("description", TextareaType::class)
            ->add("save", SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUsersId($users);
            $article->setActive(0);
            $article->setDate($date);
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('addArticle.html.twig', [
            "title" => "addArticle",
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/MyArticles", name="myArticles")
     */
    public function MyArticles()
    {
        return $this->render("myArticles.html.twig", [
            "title" => "My Articles"
        ]);
    }

    /**
     * @Route("/MyComments", name="myComments")
     */
    public function MyComments()
    {
        return $this->render("myComments.html.twig", [
            "title" => "My Comments"
        ]);
    }
}