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
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AcceptFriendController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/acceptation/ami/{friendId}', name: 'app_accept_friend')]
    #[Entity('friend', options: ['mapping' => ['friendId' => 'id']])]
    #[IsGranted('ROLE_USER')]
    public function acceptFriend(Request $request, Friend $friend): Response
    {
        $userTarget = $friend->getSendTo();
        // Vérifier si l'utilisateur connecté correspond bien au destinataire $userTarget
        /** @var User $user */
        $user = $this->getUser();
        if ($userTarget !== $user) {
            throw new AccessDeniedException('Vous n\'avez accès à cette demande.');
        }

        $form = $this->createForm(ChoiceFriendType::class, null, [
            'label' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $choice = $form->get('choice')->getData();

            if ($choice === 'accept') {
                // Créer une nouvelle instance de Friend
                $friend->setCreatedAt(new DateTimeImmutable('now'));
                $friend->setStatus('accepted');
                $this->entityManager->flush();

                $this->addFlash('sendOK', 'Demande d\'ami acceptée avec succès !');
            } elseif ($choice === 'decline') {
                $this->entityManager->remove($friend);
                $this->entityManager->flush();

                $this->addFlash('sendOK', 'Demande d\'ami déclinée avec succès !');
            }

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('accept_friend/index.html.twig', [
            'choiceFriendForm' => $form->createView(),
            'friend' => $friend,
        ]);
    }
}
