<?php

namespace App\Controller;

use App\Entity\AddFriend;
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
    #[Route('/accept/friend/{userSourceId}/{userTargetId}', name: 'app_accept_friend')]
    public function acceptFriend(Request $request, int $userSourceId, int $userTargetId): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!$this->getUser()) {
            throw new AccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $form = $this->createForm(ChoiceFriendType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // Gérer l'acceptation ou le déclin en fonction des valeurs soumises dans le formulaire

            if ($data['accept']) {
                // Accepter la demande d'ami
            } elseif ($data['decline']) {
                // Décliner la demande d'ami
            }

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('accept_friend/index.html.twig', [
            'choiceFriendForm' => $form->createView(),
        ]);
    }
}
