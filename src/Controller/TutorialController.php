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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tutoriel')]
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
        Request $request
    ): Response {
        $user = $this->getUser();
        $errors = [];
        $questions = $questionrepo->findAll();
        $progress = $progressrepo->findOneBy(['tutorial' => $tutorial, 'user' => $user]);
        if ($request->getMethod() === 'POST') {
            $quizz = $request->request->all();
            $values = array_values($quizz);

            if (count($values) < 5) {
                $errors[] = 'Veuillez répondre à toutes les questions pour avoir accès à votre score.';
            }

            if (empty($errors)) {
                if (!$progress) {
                    $progress = new Progress();
                    $progress->setUser($user);
                    $progress->setTutorial($tutorial);
                }

                $score = 0;
                foreach ($values as $answerId) {
                    $userAnswer = $answerrepo->findOneBy(['id' => $answerId]);
                    if ($userAnswer instanceof Answer && $userAnswer->isCorrect() === true) {
                        $score++;
                    }
                }
                $progress->setScore($score);
                $progress->setUpdatedAt(new DateTimeImmutable('now'));
                $progressrepo->save($progress, true);

                return $this->redirectToRoute('app_score', [
                    'slug' => $tutorial->getSlug(),
                ]);
            }
        }
        return $this->render('tutorial/show.html.twig', [
            'tutorial' => $tutorial,
            'questions' => $questions,
            'lastscore' => $progress?->getScore(),
            'lastsession' => $progress?->getUpdatedAt(),
            'errors' => $errors,
            'progress' => $progress,
        ]);
    }
}
