<?php

namespace App\Controller;

use App\Entity\Answer;
use DateTimeImmutable;
use App\Entity\Progress;
use App\Entity\Tutorial;
use App\Repository\AnswerRepository;
use App\Repository\ProgressRepository;
use App\Repository\QuestionRepository;
use App\Repository\TutorialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tutorial')]
class TutorialController extends AbstractController
{
    #[Route('/', name: 'app_tutorial')]
    public function index(TutorialRepository $tutorialRepository): Response
    {
        $tutorials = $tutorialRepository->findAll();
        return $this->render('tutorial/index.html.twig', [
            'tutorials' => $tutorials,
        ]);
    }

    #[Route('/{slug}', name: 'tutorial_show')]
    public function show(
        Tutorial $tutorial,
        AnswerRepository $answerrepo,
        QuestionRepository $questionrepo,
        ProgressRepository $progressrepo,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $user = $this->getUser();
        $questions = $questionrepo->findAll();
        $progress = $progressrepo->findOneBy(['tutorial' => $tutorial, 'user' => $user]);
        $newUpdatedAt = new DateTimeImmutable('now');

        if ($request->getMethod() === 'POST') {
            $quizz = $request->request->all();
            $values = array_values($quizz);

            if (!($progress)) {
                $progress = new Progress();
                $progress->setUser($user);
                $progress->setTutorial($tutorial);
                $progress->setUpdatedAt($newUpdatedAt);
                $progress->setScore(0);
                $entityManager->persist($progress);
                foreach ($values as $answerId) {
                    $userAnswer = $answerrepo->findOneBy(['id' => $answerId]);
                    if ($userAnswer instanceof Answer && $userAnswer->isCorrect() === true) {
                        $progress->setScore($progress->getScore() + 1);
                    }
                }
                $entityManager->flush();
            } else {
                foreach ($values as $answerId) {
                    $userAnswer = $answerrepo->findOneBy(['id' => $answerId]);
                    if ($userAnswer instanceof Answer && $userAnswer->isCorrect() === true) {
                            $progress->setScore(0);
                            $progress->setUpdatedAt($newUpdatedAt);
                            $progress->setScore($progress->getScore() + 1);
                            $entityManager->persist($progress);
                    }
                }
                $entityManager->flush();
            }
            $progressId = $progress->getId();
            return $this->redirectToRoute('app_score', [
                'progressId' => $progressId,
            ]);
        }
        return $this->render('tutorial/show.html.twig', [
            'tutorial' => $tutorial,
            'questions' => $questions,
        ]);
    }
}
