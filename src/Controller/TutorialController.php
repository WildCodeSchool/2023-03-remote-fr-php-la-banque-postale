<?php

namespace App\Controller;

use App\Entity\Tutorial;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Repository\TutorialRepository;
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
    public function show(Tutorial $tutorial, AnswerRepository $answerrepo, QuestionRepository $questionrepo): Response
    {
        $answers = $answerrepo->findAll();
        $questions = $questionrepo->findAll();

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        // }

        return $this->render('tutorial/show.html.twig', [
            'tutorial' => $tutorial,
            'answers' => $answers,
            'questions' => $questions,
        ]);
    }
}
