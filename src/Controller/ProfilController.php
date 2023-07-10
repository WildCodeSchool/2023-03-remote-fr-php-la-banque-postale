<?php

namespace App\Controller;

use App\Services\PercenTool;
use App\Repository\CategoryRepository;
use App\Repository\ProgressRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(
        QuestionRepository $questionRepository,
        ProgressRepository $progressRepository,
        CategoryRepository $categoryRepository,
        PercenTool $percenTool
    ): Response {
        $user = $this->getUser();
        $questions = $questionRepository->findAll();
        $progress = $progressRepository->findBy(['user' => $user]);
        $categories = $categoryRepository->findAll();
        $favoris = $user->getTutorialsBookmarked();
        $success = [];
        $categoryName = [];

        foreach ($categories as $categoryId) {
            $categoryObject = $categoryRepository->findOneBy(['id' => $categoryId]);
            $title = $categoryId->getTitle();
            $percentage = $percenTool->calculatePercentage($categoryObject);

            $success[$categoryId->getId()] = $percentage;
            $categoryName[$categoryId->getId()] = $title;
        }

        $score = 0;
        $totalQuestions = count($questions);

        foreach ($progress as $quizScore) {
            $score += $quizScore->getScore();
        }

        $calculPercent = $totalQuestions > 0 ? ($score / $totalQuestions) * 100 : 0;

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'calculPercent' => $calculPercent,
            'success' => $success,
            'categoryName' => $categoryName,
            'favoris' => $favoris,
        ]);
    }
}
