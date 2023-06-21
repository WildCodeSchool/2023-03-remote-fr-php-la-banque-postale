<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Answer;

class AnswerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $answer1 = new Answer();
        $answer1->setText('Oui');
        $answer1->setIsCorrect(false);
        $answer1->setQuestion($this->getReference('question_' . 1));
        $manager->persist($answer1);
        $answer2 = new Answer();
        $answer2->setText('Non');
        $answer2->setIsCorrect(false);
        $answer2->setQuestion($this->getReference('question_' . 1));
        $manager->persist($answer2);
        $answer3 = new Answer();
        $answer3->setText('Peut être');
        $answer3->setIsCorrect(false);
        $answer3->setQuestion($this->getReference('question_' . 1));
        $manager->persist($answer3);
        $manager->flush();
    }
}
