<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailChoiceController extends AbstractController
{
    #[Route('/mail/choice', name: 'app_mail_choice')]
    public function index(): Response
    {
        return $this->render('mail_choice/index.html.twig', [
            'controller_name' => 'MailChoiceController',
        ]);
    }
}
