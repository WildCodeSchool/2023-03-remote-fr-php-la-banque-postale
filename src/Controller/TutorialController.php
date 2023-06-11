<?php

namespace App\Controller;

use App\Repository\TutorialRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TutorialController extends AbstractController
{
    #[Route('/tutorial', name: 'app_tutorial')]
    public function index(TutorialRepository $tutorialRepository): Response
    {
        $this->addFlash('info', 'Inscrivez-vous dès maintenant pour profiter de plus d\'avantages !');
        $tutorials = $tutorialRepository->findAll();
        return $this->render('tutorial/index.html.twig', [
            'tutorials' => $tutorials,
        ]);
    }
}
