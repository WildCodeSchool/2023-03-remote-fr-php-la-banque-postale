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
        $tutorials = $tutorialRepository->findAll();
        return $this->render('tutorial/index.html.twig', [
            'tutorials' => $tutorials,
        ]);
    }
    /*#[Route('/tutorial/{tutorialTitle}', name: 'tutorial_show')]
    public function show(string $categoryTutorial, TutorialRepository $tutorialRepository, ProgramRepository $programRepository) : Response
    {
        $tutorial = $tutorialRepository->findOneBy(['name' => $tutorialName]);

        if (!$tutorial) {
            throw $this->createNotFoundException('Ce tutoriel n\'a pas été trouvé);
    }
        $tutorials = $tutorialRepository->findBy(
        ['tutorial' => $tutorial],
        [ 'id' => 'DESC'],
    ); 
    
        return $this->render('tutorial/show.html.twig',[
        'tutorial' => $tutorial,
        
    }*/
}
