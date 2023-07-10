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
    public function __construct()
    {
        $this->tutorialsBookmarked = new ArrayCollection();
        $this->addFriends = new ArrayCollection();
        $this->Friends = new ArrayCollection();
    }

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\ManyToMany(targetEntity: self::class)]
    private Collection $addFriends;

    #[ORM\ManyToMany(targetEntity: self::class)]
    private Collection $Friends;

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
     * @return Collection<int, self>
     */
    public function getFriends(): Collection
    {
        return $this->Friends;
    }

    public function addFriend(self $friend): static
    {
        if (!$this->Friends->contains($friend)) {
            $this->Friends->add($friend);
        }

        return $this;
    }

    public function removeFriend(self $friend): static
    {
        $this->Friends->removeElement($friend);

        return $this;
    }
}
