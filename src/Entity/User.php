<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Avatar;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Avatar $avatar = null;

    #[ORM\ManyToMany(targetEntity: Tutorial::class, inversedBy: 'users')]
    private Collection $tutorialsBookmarked;


    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\OneToMany(mappedBy: 'sendBy', targetEntity: Friend::class, orphanRemoval: true)]
    private Collection $friends;

    #[ORM\OneToMany(mappedBy: 'sendTo', targetEntity: Friend::class, orphanRemoval: true)]
    private Collection $friendOf;

    public function __construct()
    {
        $this->friends = new ArrayCollection();
        $this->friendOf = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    public function setAvatar(?Avatar $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }
    /**
     * @return Collection<int, Tutorial>
     */
    public function getTutorialsBookmarked(): Collection
    {
        return $this->tutorialsBookmarked;
    }

    public function addTutorialsBookmarked(Tutorial $tutorialsBookmarked): static
    {
        if (!$this->tutorialsBookmarked->contains($tutorialsBookmarked)) {
            $this->tutorialsBookmarked->add($tutorialsBookmarked);
        }

        return $this;
    }

    public function removeTutorialsBookmarked(Tutorial $tutorialsBookmarked): static
    {
        $this->tutorialsBookmarked->removeElement($tutorialsBookmarked);
        return $this;
    }

    /**
     * @return Collection<int, Friend>
     */
    public function getFriends(): Collection
    {
        return $this->friends;
    }

    public function addFriend(Friend $friend): static
    {
        if (!$this->friends->contains($friend)) {
            $this->friends->add($friend);
            $friend->setSendBy($this);
        }

        return $this;
    }

    public function removeFriend(Friend $friend): static
    {
        if ($this->friends->removeElement($friend)) {
            // set the owning side to null (unless already changed)
            if ($friend->getSendBy() === $this) {
                $friend->setSendBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friend>
     */
    public function getFriendOf(): Collection
    {
        return $this->friendOf;
    }

    public function addFriendOf(Friend $friendOf): static
    {
        if (!$this->friendOf->contains($friendOf)) {
            $this->friendOf->add($friendOf);
            $friendOf->setSendTo($this);
        }

        return $this;
    }

    public function removeFriendOf(Friend $friendOf): static
    {
        if ($this->friendOf->removeElement($friendOf)) {
            // set the owning side to null (unless already changed)
            if ($friendOf->getSendTo() === $this) {
                $friendOf->setSendTo(null);
            }
        }

        return $this;
    }
}
