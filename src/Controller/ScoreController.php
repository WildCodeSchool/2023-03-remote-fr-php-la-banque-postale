<?php

namespace App\Controller;

use App\Repository\ProgressRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ScoreController extends AbstractController
{
    #[Route('/score/', name: 'app_score')]
    public function index(
        ProgressRepository $progressRepository,
        Request $request,
    ): Response {
        $totalQuestion = 5;
        $progressId = $request->query->get('progressId');
        $progress = $progressRepository->findOneBy(['id' => $progressId]);
        $score = $progress->getScore();
        $successPercentage = ( $score / $totalQuestion ) * 100;
        $tutorial = $progress->getTutorial();


        return $this->render('score/result.html.twig', [
            'score' => $score,
            'successPercentage' => $successPercentage,
            'tutorial' => $tutorial,
        ]);
    }
}
