<?php

namespace App\Twig\Components;

use App\Entity\Tutorial;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('bookmark')]
final class Bookmark
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public Tutorial $tutorial;

    public function __construct(
        private Security $security,
        private UserRepository $userRepository
    ) {
    }

    #[LiveAction]
    public function toggleBookmark(): void
    {
        /** @var User $user */
        $user = $this->security->getUser();
        if ($user->getTutorialsBookmarked()->contains($this->tutorial)) {
            $user->removeTutorialsBookmarked($this->tutorial);
        } else {
            $user->addTutorialsBookmarked($this->tutorial);
        }
        $this->userRepository->save($user, true);
    }

    public function isBookmarked(): bool
    {
        /** @var User $user */
        $user = $this->security->getUser();
        return $user->getTutorialsBookmarked()->contains($this->tutorial);
    }
}
