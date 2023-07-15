<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Friend;
use App\Repository\FriendRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Services\PercenTool;
use App\Repository\CategoryRepository;
use App\Repository\ProgressRepository;
use App\Repository\QuestionRepository;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(
        Request $request,
        FriendRepository $friendRepository,
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

        foreach ($categories as $categoryObject) {
            $title = $categoryObject->getTitle();
            $percentage = $percenTool->calculatePercentage($categoryObject);

            $success[$categoryObject->getId()] = $percentage;
            $categoryName[$categoryObject->getId()] = $title;
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
