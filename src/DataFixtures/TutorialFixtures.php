<?php

namespace App\DataFixtures;

use App\Entity\Tutorial;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TutorialFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $name = [
        'Faire une photo',
        'Appeler un contact',
        'Ajouter un contact',
        'Envoyer un message',
        'Ecouter la musique',
        'Mettre une alarme',
        'Voir la météo',
        'Mettre un fond d’écran',
        ];

        for ($i = 0; $i < 8; $i++) {
            $tutorial = new Tutorial();
            $tutorial->setName($name[$i]);
            $tutorial->setDescription($faker->paragraphs(3, true));
            $tutorial->setPublic((bool) rand(0, 1));
            $manager->persist($tutorial);
        }
        $manager->flush();
    }
}
