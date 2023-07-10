<?php

namespace App\Controller;

use App\Entity\FriendList;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\AddFriendType;
use App\Entity\User;


class AddFriendController extends AbstractController
{
    #[Route('/addfriend', name: 'app_add_friend')]
    public function addfriend(
        Request $request,
        MailerInterface $mailer,
        UserRepository $userRepository,
        AddFriendType $addFriendType

    ): Response {
        $sendBy = $this->getUser();
        $form = $this->createForm(AddFriendType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sendTo = $userRepository->findOneBy(['email' => $form->get('email')->getData()]);
            if ($sendTo) {
                $friend = new Friend();

                //set valeurs à $friend
                ///persist friend
                //flush $fiend

                $email = (new Email())
                    ->from($this->getParameter('mailer_from'))
                    ->to($friend->getEmail())
                    ->subject("Demande d'ami")
                    ->html($this->renderView('add_friend/email.html.twig', [
                        'userSource' => $user,
                        'userTarget' => $friend,
                       // 'friendId' => $friend->getId()
                    ]));

                $this->addFlash('sendOK', 'Demande d\'ami envoyée avec succès !');

                $mailer->send($email);

                return $this->redirectToRoute('app_profil');
            }
        }
        return $this->render('add_friend/index.html.twig', [
            'addFriendForm' => $form,
        ]);
    }
}
