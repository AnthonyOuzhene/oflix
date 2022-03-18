<?php

namespace App\Controller\Back;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/person")
 */
class PersonController extends AbstractController
{
    /**
     * @Route("/", name="back_person_index", methods={"GET"})
     */
    public function index(PersonRepository $personRepository): Response
    {
        return $this->render('back/person/index.html.twig', [
            'people' => $personRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="back_person_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($person);
            $entityManager->flush();

            return $this->redirectToRoute('back_person_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/person/new.html.twig', [
            'person' => $person,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="back_person_show", methods={"GET"})
     */
    public function show(Person $person): Response
    {
        return $this->render('back/person/show.html.twig', [
            'person' => $person,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="back_person_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Person $person, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('back_person_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/person/edit.html.twig', [
            'person' => $person,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="back_person_delete", methods={"POST"})
     */
    public function delete(Request $request, Person $person, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$person->getId(), $request->request->get('_token'))) {
            $entityManager->remove($person);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_person_index', [], Response::HTTP_SEE_OTHER);
    }
}
