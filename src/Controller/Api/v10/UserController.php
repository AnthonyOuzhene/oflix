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
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function create(ManagerRegistry $doctrine,  UserPasswordHasherInterface $hasher, Request $request, SerializerInterface $serializer): Response
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

    /**
     * Updates a user
     * 
     * @Route("/{id}", name="update", methods="PUT", requirements={"id"="\d+"})
     * @return Response
     */
    public function update(ValidatorInterface $validator, int $id, ManagerRegistry $doctrine,  UserPasswordHasherInterface $hasher, Request $request, UserRepository $userRepository, SerializerInterface $serializer): Response
    {
/*         if (! $this->isGranted("ROLE_ADMIN"))
        {
            $data = 
            [
                'error' => true,
                'msg' => 'Il faut être admin pour accéder à ce endpoint ( You SHALL not PASS )'
            ];
            return $this->json($data, Response::HTTP_FORBIDDEN);
        } */

        // récupérer l'utilisateur dans la BDD
        $user = $userRepository->find($id);

        // gérer le cas ou l'id n'existe pas en BDD
        if (is_null($user))
        {
            // TODO comment faire pour mutulaliser / simplifier l'envoi d'erreur
            $data = [
                'error' => true,
                'message' => 'Cet identifiant est inconnu',
            ];

            return $this->json($data, Response::HTTP_NOT_FOUND);
        }
        // récupérer les données depuis la requete
        $userAsJson = $request->getContent();

        // modifier l'utilisateur
        $serializer->deserialize($userAsJson, User::class, JsonEncoder::FORMAT, [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);
        
        // on veut vérifier si on nous a envoyé un mot de passe
        // pour cela on va désérialiser le json avec php et vérifier si un champ mot de passe existe
        $userStdObj = json_decode($userAsJson);
        
        if (isset($userStdObj->password))
        {
            $hashedPassword = $hasher->hashPassword($user, $userStdObj->password);
            $user->setPassword($hashedPassword);
        }

        $errors = $validator->validate($user);
        if (count($errors) > 0)
        {
            // TODO comment faire pour mutulaliser / simplifier l'envoi d'erreur
            $data = [
                'error' => true,
                'message' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_NOT_FOUND);
        }
        
        // enregistrer le user en BDD
        $entityManager = $doctrine->getManager();

        $entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}