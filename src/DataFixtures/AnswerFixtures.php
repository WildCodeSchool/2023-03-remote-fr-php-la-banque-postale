<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Answer;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    public const ANSWERS = [
        [
            ['text' => "Un programme qui permet d'envoyer des e-mails", 'isCorrect' => false],
            ['text' => "Un logiciel pour éditer des photos", 'isCorrect' => false],
            ['text' => "Un outil pour rechercher des informations sur Internet", 'isCorrect' => true],
            ['text' => "Un système d'exploitation pour ordinateurs", 'isCorrect' => false],
        ],
        [
            ['text' => "Un mot de passe facile à deviner", 'isCorrect' => false],
            ['text' => "Un mot de passe composé de chiffres uniquement", 'isCorrect' => false],
            [
                'text' => "Un mot de passe contenant des lettres majuscules et minuscules, 
                des chiffres et des caractères spéciaux",'isCorrect' => true
            ],
            ['text' => "Un mot de passe que vous partagez avec vos amis", 'isCorrect' => false],
        ],
        [
            ['text' => "Universal Resource Locator", 'isCorrect' => true],
            ['text' => "User Registration Link", 'isCorrect' => false],
            ['text' => "User Readable Language", 'isCorrect' => false],
            ['text' => "Uniform Responsive Layout", 'isCorrect' => false],
        ],
        [
            ['text' => "L'e-mail provient d'une source connue et fiable", 'isCorrect' => false],
            ['text' => "L'e-mail demande de cliquer sur un lien et de fournir des informations personnelles",
            'isCorrect' => true],
            ['text' => "L'e-mail contient des fautes d'orthographe et de grammaire", 'isCorrect' => false],
            ['text' => "L'e-mail ne contient aucun logo ou image", 'isCorrect' => false],
        ],
        [
            [
                'text' => "Un programme qui protège votre ordinateur contre les virus et autres logiciels malveillants",
                'isCorrect' => true
            ],
            ['text' => "Un programme pour réparer les fichiers corrompus sur votre ordinateur", 'isCorrect' => false],
            ['text' => "Un outil pour créer des présentations et des diaporamas", 'isCorrect' => false],
            ['text' => "Un programme pour organiser vos photos et vidéos", 'isCorrect' => false],
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $allAnswers = $manager->getRepository(Question::class)->findAll();

        foreach ($allAnswers as $answer) {
            for ($i = 0; $i < 5; $i++) {
                $fakeanswer = new Answer();
                $fakeanswer->setText($faker->sentence(3));
                $fakeanswer->setIsCorrect(true);
                $fakeanswer->setQuestion($answer);
                $manager->persist($fakeanswer);
            }
        }
        foreach (self::ANSWERS as $index => $answers) {
            foreach ($answers as $answerValue) {
                $answer = new Answer();
                $answer->setText($answerValue['text']);
                $answer->setIsCorrect($answerValue['isCorrect']);
                $answer->setQuestion($this->getReference('question_' . $index));
                $manager->persist($answer);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            QuestionFixtures::class
        ];
    }
}
