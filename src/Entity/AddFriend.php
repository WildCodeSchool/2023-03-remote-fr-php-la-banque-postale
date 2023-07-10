<?php

namespace App\Entity;

use App\Repository\AddFriendRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddFriendRepository::class)]
class AddFriend
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $Accept = null;

    #[ORM\Column]
    private ?bool $Decline = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAccept(): ?bool
    {
        return $this->Accept;
    }

    public function setAccept(bool $Accept): static
    {
        $this->Accept = $Accept;

        return $this;
    }

    public function isDecline(): ?bool
    {
        return $this->Decline;
    }

    public function setDecline(bool $Decline): static
    {
        $this->Decline = $Decline;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }
}
