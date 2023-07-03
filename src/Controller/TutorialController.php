<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Tutorial;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Repository\TutorialRepository;
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
        Request $request
    ): Response {
        $questions = $questionrepo->findAll();
        $points = 0;

        if ($request->getMethod() === 'POST') {
            $quizz = $request->request->all();
            $values = array_values($quizz);

            foreach ($values as $answerId) {
                $userAnswer = $answerrepo->findOneBy(['id' => $answerId]);
                if ($userAnswer instanceof Answer && $userAnswer->isCorrect() === true) {
                    $points++;
                }
            }
            //sauvegarder les points en BDD;
            // return $this->redirectToRoute('nom-delaroute');
            // return $this->render('tutorial/tutorialquizz.html.twig', [
            //     'tutorial' => $tutorial,
            //     'questions' => $questions,
            //     'point' => $points,
            // ]);
        }
        return $this->render('tutorial/show.html.twig', [
            'tutorial' => $tutorial,
            'questions' => $questions,
        ]);
    }
}
