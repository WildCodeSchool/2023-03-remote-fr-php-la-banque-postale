<?php

namespace App\Controller;

use App\Repository\ProgressRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(QuestionRepository $questionRepository, ProgressRepository $progressRepository): Response
    {
        $questions = $questionRepository->findAll();
        $progress = $progressRepository->findAll();

        $score = 0;
        $totalQuestions = count($questions);

        foreach ($progress as $answer) {
            $score += $answer->getScore();
        }

        $calculPercent = $totalQuestions > 0 ? ($score / $totalQuestions) * 100 : 0;

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'calculPercent' => $calculPercent,
        ]);
    }
}
