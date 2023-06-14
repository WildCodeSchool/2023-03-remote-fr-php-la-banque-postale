<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        'Ligne bleue',
        'Utiliser mon téléphone',
        'Me divertir avec mon téléphone',
        'Mail',
        'Web',
        'Sécurité',
        'Communication',
        'Me déplacer',
    ];

    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $key => $categoryTitle) {
            $category = new Category();
            $category->setSlug($this->slugger->slug($categoryTitle));
            $category->setTitle($categoryTitle);
            $manager->persist($category);
            $this->addReference('category_' . $key, $category);
        }
        $manager->flush();
    }
}
