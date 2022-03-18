<?php

namespace App\Controller\Back;

use App\Entity\Review;
use App\Form\Review1Type;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/review")
 */
class ReviewController extends AbstractController
{
    /**
     * @Route("/", name="back_review_index", methods={"GET"})
     */
    public function index(ReviewRepository $reviewRepository): Response
    {
        return $this->render('back/review/index.html.twig', [
            'reviews' => $reviewRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="back_review_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $review = new Review();
        $form = $this->createForm(Review1Type::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('back_review_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/review/new.html.twig', [
            'review' => $review,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="back_review_show", methods={"GET"})
     */
    public function show(Review $review): Response
    {
        return $this->render('back/review/show.html.twig', [
            'review' => $review,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="back_review_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Review $review, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Review1Type::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('back_review_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/review/edit.html.twig', [
            'review' => $review,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="back_review_delete", methods={"POST"})
     */
    public function delete(Request $request, Review $review, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$review->getId(), $request->request->get('_token'))) {
            $entityManager->remove($review);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_review_index', [], Response::HTTP_SEE_OTHER);
    }
}
