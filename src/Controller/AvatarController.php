<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AvatarFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvatarController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/choix-avatar', name: 'app_select_avatar')]
    public function selectAvatar(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $avatarForm = $this->createForm(AvatarFormType::class, $user);
        $avatarForm->handleRequest($request);

        if ($avatarForm->isSubmitted() && $avatarForm->isValid()) {
            $user->setAvatar($avatarForm->get('avatar')->getData());
            $this->userRepository->save($user, true);
            return $this->redirectToRoute('app_profil');
        }

        return $this->render('avatar/index.html.twig', [
            'avatarForm' => $avatarForm->createView(),
        ]);
    }
}
