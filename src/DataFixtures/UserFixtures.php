<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setEmail('user@test.com')
            ->setName('test')
            ->setDateInscription(new DateTime())
            ->setPassword($this->passwordHasher->hashPassword(
                $user,
                'test1'
            ));
        $manager->persist($user);

        $admin = new User();
        $admin
            ->setEmail('admin@test.com')
            ->setName('admin')
            ->setDateInscription(new DateTime())
            ->setPassword($this->passwordHasher->hashPassword(
                $admin,
                'test1'
            ))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $manager->flush();
    }
}
