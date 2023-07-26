<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailTutorialController extends AbstractController
{
    #[Route('/tutoriel-mail', name: 'app_mail_tutorial')]
    public function index(): Response
    {
        return $this->render('mail_tutorial/index.html.twig');
    }
}
