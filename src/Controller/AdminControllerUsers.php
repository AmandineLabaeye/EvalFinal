<?php


namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/users")
 */
class AdminControllerUsers extends AbstractController
{

    /**
     * @Route("/u", name="users_all", methods={"GET"})
     */
    public function All(UsersRepository $usersRepository): Response
    {
        return $this->render('users/index.html.twig', [
            'users' => $usersRepository->findAll(),
            "title" => "Users"
        ]);
    }

    /**
     * @Route("/{id}", name="users_show", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        return $this->render('users/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="users_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Users $user): Response
    {
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, ['label' => false])
            ->add('name', TextType::class, ['label' => false])
            ->add('surname', TextType::class, ['label' => false])
            ->add('age', NumberType::class, ['label' => false])
            ->add('email', TextType::class, ['label' => false])
            ->add('users_level', TextType::class, ['label' => false])
            ->add('active', NumberType::class, ['label' => false])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('users_all', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="users_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Users $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('users_all');
    }

    /**
     * @Route("/users/activate", name="users_active", methods={"GET"})
     */
    public function Active(UsersRepository $usersRepository): Response
    {
        return $this->render('usersactive/liste.html.twig', [
            'users' => $usersRepository->findBy(["active" => 0]),
            "title" => "Users"
        ]);
    }

    /**
     * @Route("/{id}/edit", name="active_edit", methods={"GET","POST"})
     */
    public function EditActive(Request $request, Users $user): Response
    {
        $form = $this->createFormBuilder($user)
            ->add('active', NumberType::class, ['label' => false])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('users_active', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('useractive/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

}