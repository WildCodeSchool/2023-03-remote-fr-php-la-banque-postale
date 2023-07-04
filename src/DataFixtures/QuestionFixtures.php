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

    public static int $numRealQuestion = 0;
    public static int $numFakeQuestion = 0;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 2; $i < TutorialFixtures::$numTutorial; $i++) {
            for ($q = 0; $q < 5; $q++) {
                self::$numFakeQuestion++;
                $fakequestion = new Question();
                $fakequestion->setTitle($faker->sentence(7));
                $fakequestion->setTutorial($this->getReference('tutorial_' . $i));
                $this->addReference('fake_question_' . self::$numFakeQuestion, $fakequestion);
                $manager->persist($fakequestion);
            }
        }

        foreach (self::QUESTIONS as $questionTitle) {
            self::$numRealQuestion++;
            $question = new Question();
            $question->setTitle($questionTitle);
            $question->setTutorial($this->getReference('tutorial_1'));
            $manager->persist($question);
            $this->addReference('real_question_' . self::$numRealQuestion, $question);
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
