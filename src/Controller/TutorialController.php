<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Tutorial;
use App\Repository\CategoryRepository;
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
        $this->addFlash('info', 'Inscrivez-vous dès maintenant pour profiter de plus d\'avantages !');
        $tutorials = $tutorialRepository->findAll();
        return $this->render('tutorial/index.html.twig', [
            'tutorials' => $tutorials,
        ]);
    }
    #[Route('/{tutorialName}', name: 'tutorial_show')]
    public function show(string $tutorialName, TutorialRepository $tutorialRepository): Response
    {
        $tutorial = $tutorialRepository->findOneBy(['name' => $tutorialName]);
        return $this->render('tutorial/show.html.twig', [
            'tutorial' => $tutorial,
        ]);
    }
}
