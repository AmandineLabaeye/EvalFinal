<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Article extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function Home()
    {
        return $this->render("home.html.twig", [
            "title" => "Home"
        ]);
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function Registration()
    {
        return $this->render("registration.html.twig", [
            "title" => "Registration"
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
     * @Route("/AllArticles", name="AllArticles")
     */
    public function AllArticles()
    {
        return $this->render("articles.html.twig", [
            'title' => "All the Articles"
        ]);
    }

    /**
     * @Route("OneArticle/{id}", name="OneArticle")
     */
    public function OneArticle()
    {
        return $this->render("article.html.twig", [
            'title' => "OneArticle"
        ]);
    }

    /**
     * @Route("AddArticle", name="AddArticle")
     */
    public function AddArticles()
    {
        return $this->render('addArticle.html.twig', [
            "title" => "addArticle"
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