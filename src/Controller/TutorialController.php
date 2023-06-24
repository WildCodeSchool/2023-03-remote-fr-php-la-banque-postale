<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Form\QuizzType;
use App\Entity\Question;
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
        $answers = $answerrepo->findAll();
        $questions = $questionrepo->findAll();
        $choices = [];

        if ($request->getMethod() === 'POST') {
            $quizz = $request->request->all();
            $points=0;
            $values = array_values($quizz);

            foreach ($values as $results) {
                $result = $answerrepo->findOneBy(['id' => $results]);
                dump($result);
                if($result instanceof Answer && $result->isCorrect() === true){
                    $points++;
                }
                if($points === 3){
                    return $this->render('tutorial/champion.html.twig');
                }
            }
            return $this->render('tutorial/show.html.twig', [
                'tutorial' => $tutorial,
                'choice' => $choices,
                'answers' => $answers,
                'questions' => $questions,
                'point' => $points,
            ]);
        }

        return $this->render('tutorial/show.html.twig', [
            'tutorial' => $tutorial,
            'choice' => $choices,
            'answers' => $answers,
            'questions' => $questions,
            'point' => $points,
        ]);
    }
}
