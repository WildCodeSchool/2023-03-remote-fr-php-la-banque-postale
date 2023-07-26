<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Friend;
use DateTimeImmutable;
use App\Form\AddFriendType;
use App\Repository\FriendRepository;
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
    #[Route('/ajout/ami', name: 'app_add_friend')]
    public function addfriend(
        Request $request,
        MailerInterface $mailer,
        UserRepository $userRepository,
        AddFriendType $addFriendType,
        FriendRepository $friendRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $sendBy = $this->getUser();
        $form = $this->createForm(AddFriendType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sendTo = $userRepository->findOneBy(['email' => $form->get('email')->getData()]);
            $verifyStatus = $friendRepository->findOneBy(['sendTo' => $sendTo]);
            if ($verifyStatus) {
                if ($verifyStatus->getStatus() === 'pending') {
                    $this->addFlash('sendStatus', 'Vous avez déja envoyé une demande d\'ami.');
                } elseif ($verifyStatus->getStatus() === 'accepted') {
                    $this->addFlash('sendStatus', 'Vous êtes deja amis.');
                } elseif ($verifyStatus->getStatus() === 'decline') {
                    $this->addFlash('sendStatus', 'Demande refusée.');
                }
            } else {
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
        }
        return $this->render('add_friend/index.html.twig', [
            'addFriendForm' => $form,
        ]);
    }

    #[Route('/removefriend/{id}', name: 'app_remove_friend')]
    public function removeFriend(Friend $friend, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($friend);
        $entityManager->flush();
        $this->addFlash('removeOK', 'Ami supprimé avec succès !');

        return $this->redirectToRoute('app_profil');
    }
}
