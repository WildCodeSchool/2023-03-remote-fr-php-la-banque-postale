<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        $user = $this->getUser();
        // $friends = $user->getFriends();

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            // 'friends' => $friends,
        ]);
    }
}
