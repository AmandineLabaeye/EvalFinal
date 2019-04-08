<?php


namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Users;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/articles")
 */
class AdminControllerArticles extends AbstractController
{

    /**
     * @Route("/a", name="articles_all")
     */
    public function All(ArticlesRepository $articlesRepository)
    {
        return $this->render('articles/index.html.twig', [
            "articles" => $articlesRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="articles_show")
     */
    public function show(Articles $articles): Response
    {
        return $this->render('articles/show.html.twig', [
            'article' => $articles
        ]);
    }

    /**
     * @Route("/{id}/edit", name="articles_edit", methods={"GET","POST"})
     */
    public function edit(Articles $articles, Request $request): Response
    {
        $form = $this->createFormBuilder($articles)
            ->add('title', TextType::class)
            ->add('photo', TextType::class)
            ->add('description', TextareaType::class)
            ->add('date', TextType::class)
            ->add('active', NumberType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('articles_all', [
                'id' => $articles->getId(),
            ]);
        }

        return $this->render("articles/edit.html.twig", [
            "article" => $articles,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="articles_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Articles $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('articles_all');
    }

    /**
     * @Route("/article/active", name="articles_active", methods={"GET"})
     */
    public function ActiveA(ArticlesRepository $articlesRepository) : Response
    {
        return $this->render("articleactive/liste.html.twig", [
            "articles" => $articlesRepository->findBy(["active" => 0])
        ]);
    }

    /**
     * @Route("/{id}/edit", name="articles_active_edit", methods={"GET","POST"})
     */
    public function EditActive(Request $request, Articles $articles): Response
    {
        $form = $this->createFormBuilder($articles)
            ->add('active', NumberType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_active', [
                'id' => $articles->getId(),
            ]);
        }

        return $this->render('articleactive/edit.html.twig', [
            'article' => $articles,
            'form' => $form->createView(),
        ]);
    }
}