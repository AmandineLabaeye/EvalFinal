<?php


namespace App\Controller;


use App\Entity\Articles;
use App\Entity\Comments;
use App\Repository\ArticlesRepository;
use App\Repository\CommentsRepository;
use App\Repository\UsersRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/", name="admin")
     */
    public function index()
    {
        return $this->render("admin/index.html.twig", [
            "title" => "Index admin"
        ]);
    }

    /**
     * @Route("/home", name="home_admin")
     */
    public function Home(ArticlesRepository $articlesRepository)
    {
        return $this->render("home.html.twig", [
            "title" => "Home",
            "articles" => $articlesRepository->findBy(["active" => 1])
        ]);
    }

    /**
     * @Route("/{id}", name="OneArticle_admin", methods={"GET", "POST"})
     */
    public function OneArticle(Articles $articles, Request $request, ObjectManager $manager, ArticlesRepository $articlesRepository, $id, CommentsRepository $commentsRepository, UsersRepository $usersRepository)
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
            "comments" => $commentsRepository->findBy(["articles_id" => $id, "active" => 1]),
            "users" => $usersRepository->findBy(["id" => $users])
        ]);
    }

    /**
     * @Route("/admin/AddArticle", name="articles_new_admin")
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