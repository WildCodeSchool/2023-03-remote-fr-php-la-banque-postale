<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnexionPageController extends AbstractController
{
    #[Route('/connexion/page', name: 'app_connexion_page')]
    public function index(): Response
    {
        return $this->render('connexion_page/index.html.twig', [
            'controller_name' => 'ConnexionPageController',
        ]);
    }
}
