<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Question;

class QuestionFixtures extends Fixture
{
    public const QUESTIONS = [
        'Suis je numériquement dépressif ?',
        'Suis je vieux ?',
        'Ais je un telephone ?',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::QUESTIONS as $key => $questionTitle) {
            $question = new Question();
            $question->setTitle($questionTitle);
            $manager->persist($question);
            $this->addReference('question_' . $key, $question);
        }
        $manager->flush();
    }
}
