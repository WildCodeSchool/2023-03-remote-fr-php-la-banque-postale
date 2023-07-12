<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Friend;
use DateTimeImmutable;
use App\Form\AddFriendType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AddFriendController extends AbstractController
{
    #[Route('/addfriend', name: 'app_add_friend')]
    public function addfriend(
        Request $request,
        MailerInterface $mailer,
        UserRepository $userRepository,
        AddFriendType $addFriendType,
        EntityManagerInterface $entityManager
    ): Response {
        $sendBy = $this->getUser();
        $form = $this->createForm(AddFriendType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sendTo = $userRepository->findOneBy(['email' => $form->get('email')->getData()]);

            // if ($sendTo)
            // elseif


            if ($sendTo) {
                $friend = new Friend();
                $friend->setSendBy($sendBy);
                $friend->setSendTo($sendTo);
                $friend->setCreatedAt(new DateTimeImmutable('now'));
                $friend->setStatus('pending');
                $entityManager->persist($friend);
                $entityManager->flush();

                $email = (new Email())
                    ->from($this->getParameter('mailer_from'))
                    ->to($sendTo->getEmail())
                    ->subject("Demande d'ami")
                    ->html($this->renderView('add_friend/email.html.twig', [
                        'userSource' => $sendBy,
                        'userTarget' => $sendTo,
                        'friendId' => $friend->getId(),
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
