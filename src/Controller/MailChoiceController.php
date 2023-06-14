<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailChoiceController extends AbstractController
{
    #[Route('/choix-mail', name: 'app_mail_choice')]
    public function index(): Response
    {
        return $this->render('choix-mail/index.html.twig', [
            'controller_name' => 'MailChoiceController',
        ]);
    }
}
