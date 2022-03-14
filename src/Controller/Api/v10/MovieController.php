<?php

namespace App\Controller\Api\v10;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Créer une route qui affiche tous les movies en json 
// /api/v10/movies 


/**
 * 
 * @Route("/api/v10/movies", name="api_v10_movies_")
 */
class MovieController extends AbstractController
{

    /**
     * Get List of all movies
     * 
     * @Route("", name="list")
     * @return Response
     */
    public function list(MovieRepository $movieRepository): Response
    {
        // préparer les données
        $movieList = $movieRepository->findAll();
        

        return $this->json($movieList, Response::HTTP_OK, [], ['groups' => "api_movie_list"]);
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