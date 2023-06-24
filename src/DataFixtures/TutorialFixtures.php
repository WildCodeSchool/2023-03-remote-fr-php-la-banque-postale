<?php

namespace App\DataFixtures;

use App\Entity\Tutorial;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class TutorialFixtures extends Fixture
{
    public const TUTORIALS = [
        [
            "Introduction aux tablettes",
            "Utiliser Ligne Bleue",
            "Naviguer sur Internet",
            "Enrichir vos connaissances",
            "Regarder des séries en ligne"
        ],
        [
            'Faire une photo', 'Appeler un contact', 'Ajouter un contact', 'Envoyer un message',
            'Ecouter la musique'
        ],
        [
            "Télécharger des jeux mobiles",
            "Créer une playlist personnalisée",
            "Suivre mes émissions préférées",
            "Faire des montages vidéos",
            "Lire des livres sur mon téléphone"
        ],
        [
            "Lire mes e-mails",
            "Répondre aux e-mails",
            "Les mails indésirables",
            "Trier mes mails",
            "Gmail sur mon téléphone"
        ],
        [
            "Reconnaître un faux site",
            "Faire une recherche sur google",
            "Explorer les blogs",
            "Organiser mes favoris",
            "Les outils de traduction en ligne"
        ],
        [
            "Bien choisir mon mot de passe",
            "Protéger ma vie privée",
            "Eviter les arnaques",
            "Mes données bancaires",
            "Utiliser un antivirus"
        ],
        [
            "Envoyer des messages audio",
            "Lancer des appels vidéo",
            "Utiliser les réseaux sociaux",
            "Envoyer des cartes virtuelles",
            "Utiliser Whatsapp"
        ],
        [
            "Reserver des transports en ligne",
            "Utiliser un GPS",
            "Les déplacements écologiques",
            "Utiliser Mappy",
            "Utiliser Uber"
        ]
    ];

    public const TUTORIALTEL = [
        'Mettre une alarme',
        'Voir la météo',
        'Mettre un fond d’écran',
    ];

    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        foreach (self::TUTORIALS as $key => $tutorialName) {
            for ($i = 0; $i < 5; $i++) {
                $tutorial = new Tutorial();
                $tutorial->setSlug($this->slugger->slug($tutorialName[$i]));
                $tutorial->setObjective($faker->sentence(12));
                $tutorial->setName($tutorialName[$i]);
                $tutorial->setDescription($faker->paragraphs(3, true));
                $tutorial->setPublic((bool) rand(0, 1));
                $tutorial->setCategory($this->getReference('category_' . $key));
                $manager->persist($tutorial);
            }
        }

        foreach (self::TUTORIALTEL as $tutorialName) {
            $tutorialtel = new Tutorial();
            $tutorialtel->setSlug($this->slugger->slug($tutorialName));
            $tutorialtel->setObjective($faker->sentence(12));
            $tutorialtel->setName($tutorialName);
            $tutorialtel->setDescription($faker->paragraphs(3, true));
            $tutorialtel->setPublic((bool) rand(0, 1));
            $tutorialtel->setCategory($this->getReference('category_' . 1));
            $manager->persist($tutorialtel);
        }

        $manager->flush();
    }
}
