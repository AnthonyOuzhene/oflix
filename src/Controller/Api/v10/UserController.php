<?php

namespace App\Controller\Api\v10;

use App\Entity\Movie;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 
 * @Route("/api/v10/users", name="api_v10_users_", methods ={"GET"})
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
        
        return $this->json($usersList, Response::HTTP_OK, [], ['groups' => "api_users"]);
    }

     /**
     * Display details of one movie
     * 
     * @Route("/{id}", name="movie_users", requirements={"id"="\d+"}, methods ={"GET"})
     * @return Response
     */
    public function read(int $id, UserRepository $userRepository): Response
    {
        // préparer les données
        $user = $userRepository->find($id);

        if (is_null($user))
        {
            $data = 
            [
                'error' => true,
                'message' => 'User not found',
            ];
            return $this->json($data, Response::HTTP_NOT_FOUND, []);
        }

        return $this->json($user, Response::HTTP_OK, [], ['groups' => "api_users"]);
    }

    

}