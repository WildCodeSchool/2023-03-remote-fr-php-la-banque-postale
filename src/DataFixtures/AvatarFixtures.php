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
            'Avatar_1.png',
            'Avatar_2.png',
            'Avatar_3.png',
            'Avatar_4.png',
            'Avatar_5.png',
            'Avatar_6.png',
            'Avatar_7.png',
            'Avatar_8.png',
            'Avatar_9.png',
            'Avatar_10.png',
            'Avatar_11.png',
            'Avatar_12.png',
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
