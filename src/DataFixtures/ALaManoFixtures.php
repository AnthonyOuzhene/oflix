<?php

namespace App\DataFixtures;

use App\Entity\Casting;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use App\Repository\CastingRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ALaManoFixtures extends Fixture
{

    private $slugger;

public function __construct(SluggerInterface $slugger)
{
    $this->slugger = $slugger;
}

    public function load(ObjectManager $manager): void
    {
        $fightClub = [
            'title' => 'Fight Club',
            'type' => 'movie',
            'releaseDate' => '1998-01-01',
            'summary' => 'Un employé de bureau insomniaque et un fabriquant de savons forment un club de combat clandestin qui devient beaucoup plus que ça',
            'synopsis' => 'Du savon, des combats !',
            'duration' => 139,
            'rating' => 4.9,
            'poster' => 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcTdLTXtlwgmOU3b9iXMccLmWsFVJlBxwG3PBodcNk2O3SfJx1Jx',
            'genres' => [
                'Combat',
                'Savon',
                'Graisse',
            ],
            'casting' => [
                [
                    'firstName' => 'Brad',
                    'lastName' => 'Pitt',
                    'creditOrder' => 1,
                    'role' => 'Tyler Durden',
                ],
                [
                    'firstName' => 'Edward',
                    'lastName' => 'Norton',
                    'creditOrder' => 2,
                    'role' => 'The narrator',
                ]
            ]
        ];
        $uncharted = [
            'title' => 'Uncharted',
            'type' => 'movie',
            'releaseDate' => '2022-02-16',
            'summary' => 'Des bateaux qui volent',
            'synopsis' => 'Nathan Drake, voleur astucieux et intrépide, est recruté par le chasseur de trésors chevronné Victor « Sully » Sullivan pour retrouver la fortune de Ferdinand Magellan',
            'duration' => 114,
            'rating' => 3.6,
            'poster' => 'https://fr.web.img4.acsta.net/c_310_420/pictures/22/01/18/10/13/5983633.jpg',
            'genres' => [
                'Aventure',
                'Jeux video'
            ],
            'casting' => [
                [
                    'firstName' => 'Holland',
                    'lastName' => 'Tom',
                    'creditOrder' => 1,
                    'role' => 'Nathan Draken',
                ],
                [
                    'firstName' => 'Mark',
                    'lastName' => 'Whalberg',
                    'creditOrder' => 2,
                    'role' => 'Victor Sullivan',
                ]
            ]
        ];
        $dinerDeCon = [
            'title' => 'Le dîner de cons',
            'type' => 'movie',
            'releaseDate' => '1998-04-15',
            'summary' => 'Il est mignon monsieur Pignon, il est méchant monsieur Brochant',
            'synopsis' => 'To amuse themselves at a weekly dinner, a few well-heeled folk each bring a dimwit along who is to talk about his pastime. Each member seeks to introduce a champion dumbbell. Pierre, an avid participant of the game, runs into one problem after another that devilishly compromises his secrets, turning the tables on him and his objective, which diverges as the movie progresses. Firstly, wishing to be certain he has selected a winner, he invited his guest, Mr. Pignon, to meet him at home before setting off; but night of all nights, Pierre has put his back out and it is questionable whether he can manage to get to the dinner. The blundering Mr. Pignon will continually spring forward to help relieve Pierre of his troubles, which have drastically compounded, pointing in the direction of friends, taxes and women...
            ',
            'duration' => 139,
            'rating' => 4.9,
            'poster' => 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcTdLTXtlwgmOU3b9iXMccLmWsFVJlBxwG3PBodcNk2O3SfJx1Jx',
            'genres' => [
                'Comique',
                'Repas',
            ],
            'casting' => [
                [
                    'firstName' => 'Thierry',
                    'lastName' => 'Lhermitte',
                    'creditOrder' => 1,
                    'role' => 'Pierre Bronchant',
                ],
                [
                    'firstName' => 'Jacques ',
                    'lastName' => 'Villeret',
                    'creditOrder' => 2,
                    'role' => 'François Pignon',
                ]
            ]
        ];
        $jediSReturn = [
            'title' => 'Star Wars ep. VI - Le retour du Jedi',
            'type' => 'movie',
            'releaseDate' => '1983-01-01',
            'summary' => 'L\'Empire se prépare à anéantir l\'Alliance Rebelle grâce une nouvelle Etoile Noire',
            'synopsis' => 'Alors que l\'Empire se prépare à anéantir l\'Alliance Rebelle grâce une nouvelle Etoile Noire, Luke Skywalker (Mark Hamill) sauve Han Solo (Harrison Ford) des griffes de Jabba Le Hutt. Dans la forêt d\'Endor, les Rebelles tentent de détruire la nouvelle arme de l\'Empire avec l\'aide des Ewoks. Luke affronte à nouveau son père Dark Vador dans un duel épique au cour de l\'Etoile Noire. Vador doit alors faire face au plus important des choix. la vie de son fils et la liberté de toute la galaxie sont en jeu.',
            'duration' => 130,
            'rating' => 4.9,
            'poster' => 'https://m.media-amazon.com/images/I/61ly2hGYbzS._AC_SL1000_.jpg',
            'genres' => [
                'Action',
            ],
            'casting' => [
                [
                    'firstName' => 'Mark',
                    'lastName' => 'Hamill',
                    'creditOrder' => 1,
                    'role' => 'Luke Skywalker',
                ],
                [
                    'firstName' => 'Carrie',
                    'lastName' => 'Fischer',
                    'creditOrder' => 2,
                    'role' => 'Leia Organa',
                ]
            ]
        ];
        $kaamelott = [
            'title' => 'Kaamelott',
            'type' => 'movie',
            'releaseDate' => '2021-07-21',
            'summary' => 'Le film se déroulant 15 après les aventures de la série du même nom !',
            'synopsis' => '484 : Dix ans après que Lancelot a pris le pouvoir. Il organise une chasse aux sorcières - aidés par des mercenaires saxons - pour retrouver Arthur et ses chevaliers, aujourd\'hui, divisés et dispersés. Ce dernier, exilé jusqu\'à son ancienne patrie, Rome, pour échapper à la folie de Lancelot se trouve dans la maison abandonnée de sa première femme Aconia. Souffrant sous le joug de Lancelot, le Royaume de Logres résiste et attend le retour de son héros.',
            'duration' => 120,
            'rating' => 5.0,
            'poster' => 'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcT8fm-HVtF6uGg9FElVaG3oUUq6xd0AlMNRE7sE5v8ljHvUcW1v',
            'genres' => [
                'Epique',
                'Comique',
                'Pays de Galles INDEPENDANT',
            ],
            'casting' => [
                [
                    'firstName' => 'Alexandre',
                    'lastName' => 'Astier',
                    'creditOrder' => 1,
                    'role' => 'Arthur',
                ],
                [
                    'firstName' => 'Alain',
                    'lastName' => 'Chabat',
                    'creditOrder' => 2,
                    'role' => 'Duc d\'Aquitaine',
                ]
            ]
        ];
        $westworld = [
            'title' => 'Westworld',
            'type' => 'tvshow',
            'releaseDate' => '2021-07-21',
            'summary' => 'du wester, des robots et on fait travailler les méninges',
            'synopsis' => 'un parc d\'attraction pour les riches dans un futur morose',
            'duration' => 90,
            'rating' => 4.1,
            'poster' => 'https://m.media-amazon.com/images/I/81qzhtGje1L._AC_SY679_.jpg',
            'genres' => [
                'western',
                'futuriste',
            ],
            'casting' => [
                [
                    'firstName' => 'Ed',
                    'lastName' => 'Harris',
                    'creditOrder' => 1,
                    'role' => 'L\'homme en noir',
                ],
                [
                    'firstName' => 'Evan Rachel Wood',
                    'lastName' => 'Wood',
                    'creditOrder' => 2,
                    'role' => 'Dolores Abernathy',
                ],
                [
                    'firstName' => 'Jeffrey',
                    'lastName' => 'Wright',
                    'creditOrder' => 2,
                    'role' => 'Bernard Lowe',
                ]
            ]
        ];

        $movies[] = $uncharted;
        $movies[] = $fightClub;
        $movies[] = $kaamelott;
        $movies[] = $dinerDeCon;
        $movies[] = $jediSReturn;
        $movies[] = $westworld;


        foreach ($movies as $currentMovie) {
            // ajouter le movie
            $movie = new Movie();
            $movie->setTitle($currentMovie['title']);
            $movie->setType($currentMovie['type']);

            $slug = (strtolower($this->slugger->slug($movie->getTitle()) ));
            $movie->setSlug($slug);

            $movie->setSummary($currentMovie['summary']);
            $movie->setSynopsis($currentMovie['synopsis']);
            $movie->setDuration($currentMovie['duration']);
            $movie->setRating($currentMovie['rating']);
            $movie->setPoster($currentMovie['poster']);
            $movie->setReleaseDate(new DateTime($currentMovie['releaseDate']));

            // dire à Doctrine de gérer le nouvel objet
            $manager->persist($movie);


            // ajouter les genres
            foreach ($currentMovie['genres'] as $currentGenre) {
                $genre = new Genre();
                $genre->setName($currentGenre);

                $movie->addGenre($genre);

                $manager->persist($genre);
            }

            // ajouter les person / casting

            // ajouter les relations movie / person

            // ajouter les relations movie / genre

            foreach ($currentMovie['casting'] as $currentCasting) {
                $person = new Person();
                $person->setFirstName($currentCasting['firstName']);
                $person->setLastName($currentCasting['lastName']);

                $manager->persist($person);

                $casting = new Casting();
                $casting->setCreditOrder($currentCasting['creditOrder']);
                $casting->setRole($currentCasting['role']);

                $manager->persist($casting);

                $casting->setPerson($person);
                $casting->setMovie($movie);
            }
        }

        $manager->flush();
    }
}
