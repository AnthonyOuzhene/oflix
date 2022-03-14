<?php

namespace App\Controller\Api\v10;

use App\Entity\Movie;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 
 * @Route("/api/v10/users", name="api_v10_users_")
 */
class UserController extends AbstractController
{
    /**
     * Get List of all users
     * 
     * @Route("", name="list")
     * @return Response
     */
    public function list(UserRepository $userRepository): Response
    {
        // préparer les données
        $usersList = $userRepository->findAll();
        
        return $this->json($usersList, Response::HTTP_OK, [], ['groups' => "api_users_list"]);
    }

     /**
     * Display details of one movie
     * 
     * @Route("/{id}", name="movie_details", requirements={"id"="\d+"}, methods ={"GET"})
     * @return Response
     */
    public function movie_details(Movie $movie = null): Response
    {
        // Le Param Converter prépare les données

        // Gérer si film donné n'existe pas
        if ($movie === null)
        {
            return $this->json(['error' => 'Ce film n\'existe pas. Veuillez rentrer un id connu.']);
        }

        return $this->json($movie,
        Response::HTTP_OK,
        [],
        ['groups' => "api_movie_details"]);
    }

    

}