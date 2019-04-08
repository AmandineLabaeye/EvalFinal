<?php


namespace App\Controller;

use App\Entity\Comments;
use App\Repository\CommentsRepository;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin/comments")
 */
class AdminControllerCommentaires extends AbstractController
{
    /**
     * @Route("/c", name="comments_all")
     */
    public function All(CommentsRepository $commentsRepository)
    {
        return $this->render('comments/index.html.twig', [
            "comments" => $commentsRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="comments_show")
     */
    public function show(Comments $comments): Response
    {
        return $this->render("comments/show.html.twig", [
            'comment' => $comments
        ]);
    }

    /**
     * @Route("/{id}/edit", name="comments_edit", methods={"GET", "POST"})
     */
    public function edit(Comments $comments, Request $request): Response
    {
        $form = $this->createFormBuilder($comments)
            ->add("content", TextType::class, ["label" => false])
            ->add('date', TextType::class, ["label" => false])
            ->add("active", TextType::class, ["label" => false])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute("comments_all", [
                'id' => $comments->getId(),
            ]);
        }

        return $this->render('comments/edit.html.twig', [
            "comment" => $comments,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="comments_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Comments $comment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comments_all');
    }

    /**
     * @Route("/comment/active", name="comments_active", methods={"GET"})
     */
    public function ActiveC(CommentsRepository $commentsRepository): Response
    {
        return $this->render("commentactive/liste.html.twig", [
            "comments" => $commentsRepository->findBy(["active" => 0])
        ]);
    }

    /**
     * @Route("/{id}/edit", name="comments_active_edit", methods={"GET","POST"})
     */
    public function EditActive(Request $request, Comments $comments): Response
    {
        $form = $this->createFormBuilder($comments)
            ->add('active', NumberType::class, ["label" => false])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comments_active', [
                'id' => $comments->getId(),
            ]);
        }

        return $this->render('commentactive/edit.html.twig', [
            'comment' => $comments,
            'form' => $form->createView(),
        ]);
    }
}