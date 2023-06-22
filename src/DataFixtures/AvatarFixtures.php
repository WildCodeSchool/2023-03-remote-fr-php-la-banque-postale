<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Avatar;

class AvatarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $avatars = [
            'cat.gif',
            'cocci.gif',
            'fun.gif',
            'man.gif',
            'man2.gif',
            'man3.gif',
            'monkey.gif',
            'pika.gif',
            'titi.gif',
            'wolf.gif',
            'women.gif',
            'women2.gif',
            // Ajoutez les noms de vos images d'avatar supplémentaires ici
        ];

        foreach ($avatars as $avatar) {
            $avatarEntity = new Avatar();
            $avatarEntity->setName($avatar);
            $avatarEntity->setPath($avatar); // Mettez à jour le chemin d'accès approprié à vos images d'avatar

            $manager->persist($avatarEntity);
        }


        $manager->flush();
    }
}
