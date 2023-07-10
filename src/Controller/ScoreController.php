<?php

namespace App\Controller;

use App\Entity\Tutorial;
use App\Repository\ProgressRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ScoreController extends AbstractController
{
    #[Route('/score/{slug}', name: 'app_score')]
    public function index(
        Tutorial $tutorial,
        ProgressRepository $progressRepository
    ): Response {
        $totalQuestion = count($tutorial->getQuestions());
        $user = $this->getUser();
        $progress = $progressRepository->findOneBy(['tutorial' => $tutorial, 'user' => $user]);
        $score = $progress?->getScore() ?: 0;
        $successPercentage = ( $score / $totalQuestion ) * 100;

        return $this->render('score/result.html.twig', [
            'score' => $score,
            'successPercentage' => $successPercentage,
            'tutorial' => $tutorial,
        ]);
    }
}
