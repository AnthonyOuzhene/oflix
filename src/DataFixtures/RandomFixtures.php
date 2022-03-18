<?php

namespace App\DataFixtures;

use App\Entity\Casting;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Season;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory as ExceptionFactory;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class RandomFixtures extends Fixture
{
private $slugger;

public function __construct(SluggerInterface $slugger)
{
    $this->slugger = $slugger;
}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        // préparer les données

        // créer une liste de genre et les stocker dans un tableau
        $genres = [
            'Action',
            'Animation',
            'Aventure',
            'Comédie',
            'Dessin animé',
            'Documentaire',
            'Drame',
            'Espionnage',
            'Famille',
            'Fantastique',
            'Historique',
            'Policier',
            'Romance',
            'Science-fiction',
            'Thriller',
            'Western',
        ];

        // va contenir les objets genre que l'on a créé
        $genreObjects = [];

        foreach ($genres as $currentGenre) {
            $genre = new Genre();
            $genre->setName($currentGenre);

            $genreObjects[] = $genre;
            $manager->persist($genre);
        }

        // créer une liste de personne et les stocker dans un tableau
        $nbActeurs = 0;
        $personObjects = [];
        for ($i = 0; $i < $nbActeurs; $i++) {
            $person = new Person();
            $person->setFirstname($faker->firstName());
            $person->setLastname($faker->lastName());

            $personObjects[] = $person;
            $manager->persist($person);
        }

        // créer une liste de movie 
        // pour chaque movie piocher un nombre de genre aléatoire à associer
        // pour chaque movie piocher un nombre de personnes aléatoire pour créer des castings
        $nbMovie = 0;

        $types = [
            'movie',
            'série',
        ];
        for ($movieCount = 0; $movieCount < $nbMovie; $movieCount++) {
            // ajouter le movie
            $movie = new Movie();

            $movie->setTitle('Titre '  . $movieCount);

            $slug = strtolower($this->slugger->slug($movie->getTitle()));
            $movie->setSlug($slug);

            $typeIndex = rand(0, 1);
            $movie->setType($types[$typeIndex]);
            $movie->setSummary($faker->sentence());
            $movie->setSynopsis($faker->paragraph());
            $movie->setDuration($faker->numberBetween(45, 185));
            $movie->setRating($faker->randomFloat(1, 0, 5));
            $movie->setPoster('https://picsum.photos/id/' . ($movieCount + 1) . '/200/300');
            $movie->setReleaseDate(new DateTime());

            // ajouter les associations avec Genre
            for ($i = 0; $i <= rand(1, 5); $i++) {
                $randomIndex = array_rand($genreObjects);
                $movie->addGenre($genreObjects[$randomIndex]);
            }

                        // Seasons
            // On vérifie si l'entitéeMovie est une série ou pas
            if ($movie->getType() === 'Série') {
                // Si oui on créer une bouble for avec un numéro aléatoire dans la condition pour déterminer le nombre de saisons
                // mt_rand() ne sera exécuté qu'une fois en début de boucle
                for ($j = 1; $j <= mt_rand(3, 8); $j++) {
                    // On créé la nouvelle entitée Season
                    $season = new Season();
                    // On insert le numéro de la saison en cours $j
                    $season->setNumber($j);
                    // On insert un numéro d'épisode aléatoire
                    $season->setEpisodesNumber(mt_rand(6, 24));
                    // Puis on relie notre saison à notre série
                    $season->setMovie($movie);
                    // On persite
                    $manager->persist($season);
                }
            }

            // Ajouter des castings
            for ($i = 0; $i <= rand(5, 25); $i++) {
                $casting = new Casting();

                $casting->setMovie($movie);

                $randomIndex = array_rand($personObjects);
                $casting->setPerson($personObjects[$randomIndex]);

                $casting->setRole($this->generateRandomString(rand(6, 10)));
                $casting->setCreditOrder($i);

                $manager->persist($casting);
            }

            // dire à Doctrine de gérer le nouvel objet
            $manager->persist($movie);
        }

        $user = new User();
        $user->setEmail('admin@admin.com');
        // password is admin
        $user->setPassword('$2y$13$mc9q6YGcasPeb4aYFMPanOnCql.LjbtbANDDghzZn/UVGm1l7MheG');
        $user->setRoles(['ROLE_ADMIN']);

        $user = new User();
        $user->setEmail('antho@antho.com');
        // password is antho
        $user->setPassword('$2y$13$v9Y5L3JzI7ku40ppuBtf4uOsRmEu.5iA28dFZdWyaHxKtw8W2Xv22');
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('manager@manager.com');
        // password is manager
        $user->setPassword('$2y$13$E4FABdaAhWZqelmltNSnru8hMTDOLDTDapVa0QkDxZh6zlDcPZ.06');
        $user->setRoles(['ROLE_MANAGER']);
        $manager->persist($user);

        
        $user = new User();
        $user->setEmail('user@user.com');
        // password is user
        $user->setPassword('$2y$13$iq3QG8R0hMInrRXQ6wQhzOMLyQBMw9fx75rFEp0pTIaUhFzLHPZ2a');
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        
        $manager->flush();
    }

    /**
     * @param int $length
     * @param string $abc
     * @return string
     */
    public function generateRandomString($length, $abc = "abcdefghijklmnopqrstuvwxyz")
    {
        return substr(str_shuffle($abc), 0, $length);
    }
}
