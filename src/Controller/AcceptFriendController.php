<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Friend;
use DateTimeImmutable;
use App\Form\ChoiceFriendType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AcceptFriendController extends AbstractController
{
    private $userRepository;
    private $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/accept/friend/{userSourceId}/{userTargetId}', name: 'app_accept_friend')]
    public function acceptFriend(Request $request, int $userSourceId, int $userTargetId): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!$this->getUser()) {
            throw new AccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $userSource = $this->userRepository->find($userSourceId);
        $userTarget = $this->userRepository->find($userTargetId);

        if (!$userSource || !$userTarget) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        $form = $this->createForm(ChoiceFriendType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if ($data['accept']) {
                $friendship = $this->entityManager->getRepository(Friend::class)->findOneBy([
                    'sendBy' => $userSource,
                    'sendTo' => $userTarget,
                    'status' => 'pending',
                ]);

                if ($friendship) {
                    $friendship->setStatus('accepted');
                    $this->entityManager->flush();

                    // Créer une nouvelle instance de Friend
                    $newFriend = new Friend();
                    $newFriend->setSendBy($userSource);
                    $newFriend->setSendTo($userTarget);
                    $newFriend->setCreatedAt(new DateTimeImmutable('now'));
                    $newFriend->setStatus('accepted');
                    $this->entityManager->persist($newFriend);
                    $this->entityManager->flush();

                    $this->addFlash('success', 'Demande d\'ami acceptée avec succès !');
                } else {
                    $this->addFlash('error', 'La demande d\'ami n\'existe pas ou a déjà été traitée.');
                }
            } elseif ($data['decline']) {
                $friendship = $this->entityManager->getRepository(Friend::class)->findOneBy([
                    'sendBy' => $userSource,
                    'sendTo' => $userTarget,
                    'status' => 'pending',
                ]);

                if ($friendship) {
                    $this->entityManager->remove($friendship);
                    $this->entityManager->flush();

                    $this->addFlash('success', 'Demande d\'ami déclinée avec succès !');
                } else {
                    $this->addFlash('error', 'La demande d\'ami n\'existe pas ou a déjà été traitée.');
                }
            }

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('accept_friend/index.html.twig', [
            'choiceFriendForm' => $form->createView(),
        ]);
    }
}
