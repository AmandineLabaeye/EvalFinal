<?php


namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\ArticlesRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class  AllController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function Home(ArticlesRepository $articlesRepository)
    {
        return $this->render("home.html.twig", [
            "title" => "Home",
            "articles" => $articlesRepository->findBy(["active" => 1])
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
     * @Route("/new", name="users_new", methods={"GET","POST"})
     */
    public function new(Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $hash = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setActive(0);
            $user->setUsersLevel("ROLE_USER");
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('users/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            "title" => "Registration"
        ]);
    }

}