<?php

namespace App\DataFixtures;

use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Question;
use App\Entity\Tutorial;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    public const QUESTIONS = [
        "Qu'est-ce qu'un navigateur web ?",
        "Qu'est-ce qu'un mot de passe sécurisé ?",
        'Que signifie l\'abréviation "URL" ?',
        "Comment reconnaître un e-mail de phishing ?",
        "Qu'est-ce qu'un logiciel antivirus ?",
    ];

    public static int $numQuestion = 0;


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $allQuestions = $manager->getRepository(Tutorial::class)->findAll();
        $fakerTutorial = array_slice($allQuestions, 1);

        foreach ($fakerTutorial as $question) {
            for ($i = 0; $i < 5; $i++) {
                $fakequestion = new Question();
                $fakequestion->setTitle($faker->sentence(7));
                $fakequestion->setTutorial($question);
                $manager->persist($fakequestion);
            }
        }
        foreach (self::QUESTIONS as $key => $questionTitle) {
            self::$numQuestion++;
            $question = new Question();
            $question->setTitle($questionTitle);
            $question->setTutorial($this->getReference('tutorial_1'));
            $manager->persist($question);
            $this->addReference('question_' . $key, $question);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TutorialFixtures::class
        ];
    }
}
