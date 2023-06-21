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
        'Faire une photo',
        'Appeler un contact',
        'Ajouter un contact',
        'Envoyer un message',
        'Ecouter la musique',
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

        foreach (self::TUTORIALS as $tutorialName) {
            $tutorial = new Tutorial();
            $tutorial->setSlug($this->slugger->slug($tutorialName));
            $tutorial->setObjective($faker->sentence(12));
            $tutorial->setName($tutorialName);
            $tutorial->setDescription($faker->paragraphs(3, true));
            $tutorial->setPublic((bool) rand(0, 1));
            $tutorial->setCategory($this->getReference('category_' . 1));
            $manager->persist($tutorial);
        }
        $manager->flush();
    }
}
