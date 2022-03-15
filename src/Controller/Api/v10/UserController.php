<?php

namespace App\Controller\Api\v10;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Migrations\Configuration\EntityManager\ManagerRegistryEntityManager;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\JsonDecoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

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

    /**
     * Creates a user
     * 
     * @Route("", name="create", methods="POST")
     * @return Response
     */
    public function create(ManagerRegistry $doctrine, UserPasswordHasherInterface $hasher, Request $request, SerializerInterface $serializer): Response
    {
        // récupérer les données depuis la requete
        $userAsJson = $request->getContent();

        /** @var User $user */
        $user = $serializer->deserialize($userAsJson, User::class, JsonEncoder::FORMAT);

        $hashedPassword = $hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);

        // enregistrer le user en BDD
        $entityManager = $doctrine->getManager();

        $entityManager->persist($user);

        $entityManager->flush();

        $data = [
            'id' => $user->getId(),
        ];


        return $this->json($data, Response::HTTP_CREATED);
    }
}