<?php

namespace App\DataFixtures;

use App\Entity\Tutorial;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TutorialFixtures extends Fixture implements DependentFixtureInterface
{
    public const TUTORIALS = [
        [
            "Introduction aux tablettes : découvrez les fonctionnalités essentielles",
            "Utiliser les applications de musique en streaming pour écouter vos chansons préférées",
            "Naviguer sur Internet pour trouver des informations pratiques sur la santé et le bien-être",
            "Découvrir les podcasts et les livres audio pour enrichir vos connaissances",
            "Utiliser les services de streaming vidéo pour regarder des films et des séries en ligne"
        ],
        [
            'Faire une photo', 'Appeler un contact', 'Ajouter un contact', 'Envoyer un message',
            'Ecouter la musique'
        ],
        [
            "Découvrir les jeux mobiles : comment télécharger, installer et jouer",
            "Utiliser les applications de streaming musical pour créer des playlists personnalisées",
            "Explorer le monde du podcast : comment trouver, écouter et suivre vos émissions préférées",
            "Créer et partager des vidéos amusantes avec des applications de montage sur votre téléphone",
            "Explorer le monde de la lecture numérique : applications pour les livres électroniques et les magazines"
        ],
        [
            "Maîtriser les fonctions de base de votre boîte de réception : lire, écrire et répondre aux e-mails",
            "Gérer les spams et les courriers indésirables dans votre boîte de réception",
            "Créer des filtres pour trier automatiquement vos e-mails",
            "Utiliser les options de mise en forme pour rendre vos e-mails plus attrayants",
            "Configurer votre boîte de réception sur votre téléphone portable pour recevoir vos e-mails en déplacement"
        ],
        [
            "Naviguer en toute sécurité : reconnaître les sites sûrs et éviter les pièges en ligne",
            "Utiliser les moteurs de recherche avancés pour des résultats plus précis",
            "Explorer les blogs et les forums pour trouver des informations spécialisées",
            "Gérer vos favoris et créer des dossiers pour organiser vos sites préférés",
            "Utiliser les outils de traduction en ligne pour communiquer avec des personnes du monde entier"
        ],
        [
            "Sécuriser vos comptes en ligne : conseils pour des mots de passe forts et un suivi régulier",
            "Protéger votre vie privée sur les réseaux sociaux : 
            paramètres de confidentialité et contrôle des informations",
            "Reconnaître et éviter les tentatives de phishing par e-mail",
            "Sauvegarder vos données importantes : méthodes simples et efficaces",
            "Utiliser un antivirus et un pare-feu pour protéger votre ordinateur contre les menaces en ligne"
        ],
        [
            "Utiliser les applications de messagerie vocale pour envoyer et recevoir des messages audio",
            "Participer à des appels vidéo de groupe pour rester connecté avec votre famille élargie",
            "Utiliser les réseaux sociaux pour partager des moments de votre vie avec vos proches",
            "Créer et envoyer des cartes virtuelles pour célébrer des occasions spéciales",
            "Utiliser les applications de messagerie instantanée pour discuter en 
            temps réel avec vos amis et votre famille"
        ],
        [
            "Trouver et réserver des billets de transport en ligne : trains, avions, bus",
            "Utiliser les applications de navigation en temps réel pour éviter les embouteillages",
            "Découvrir les applications de partage de vélos et de trottinettes pour des déplacements écologiques",
            "Comprendre les applications de transport en commun pour planifier vos trajets efficacement",
            "Utiliser les services de location de voitures pour vos déplacements ponctuels ou vos vacances"
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
                $this->addReference('tutorial_' . $tutorialName[$i], $tutorial);
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

    public function getDependencies()
    {
        return [
        CategoryFixtures::class
        ];
    }
}
