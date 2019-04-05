<?php


namespace App\Controller;


use App\Entity\Articles;
use App\Entity\Comments;
use App\Repository\ArticlesRepository;
use App\Repository\CommentsRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/member")
 */
class MemberController extends AbstractController
{
    /**
     * @Route("/", name="home_member")
     */
    public function Home(ArticlesRepository $articlesRepository)
    {
        return $this->render("home.html.twig", [
            "title" => "Home",
            "articles" => $articlesRepository->findBy(["active" => 1])
        ]);
    }

    /**
     * @Route("/{id}", name="OneArticle_member", methods={"GET", "POST"})
     */
    public function OneArticle(Articles $articles, Request $request, ObjectManager $manager, ArticlesRepository $articlesRepository, $id, CommentsRepository $commentsRepository)
    {
        $comment = new Comments();

        $idA = $articlesRepository->find($id);

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
            $comment->setArticlesId($idA);
            $manager->persist($comment);
            $manager->flush();

            $this->redirectToRoute('home');
        }

        return $this->render("article.html.twig", [
            'title' => "OneArticle",
            "article" => $articles,
            "form" => $form->createView(),
            "comments" => $commentsRepository->findBy(["articles_id" => $id, "active" => 1])
        ]);
    }

    /**
     * @Route("/member/AddArticle", name="articles_new_member")
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

}