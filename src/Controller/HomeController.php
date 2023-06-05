<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'website' => 'LIGNE BLEUE',
            'slogan' => '“Rendre visible les invisibles du numérique”',
            'presentation' => '“La Ligne Bleue est un site dédié à accompagner les personnes qui rencontrent
            des difficultés avec les nouvelles technologies. Il offre une variété de tutoriels pour aider les 
            utilisateurs à maîtriser différents outils et applications. En créant un compte, les utilisateurs 
            peuvent suivre leur progression et accéder à des formations personnalisées, leur permettant ainsi 
            de développer leurs compétences technologiques à leur propre rythme.”',
        ]);
    }
}
