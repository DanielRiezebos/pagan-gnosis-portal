<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: "username", length: 255)]
    private ?string $username = null;

    #[ORM\Column(name: "email", length: 255)]
    private ?string $email = null;

    #[ORM\Column(name: "password", length: 255)]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false, name: "role_id")]
    private ?Role $role = null;

    /**
     * @var Collection<int, GnosisEntry>
     */
    #[ORM\OneToMany(targetEntity: GnosisEntry::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $gnosisEntries;

    /**
     * @var Collection<int, ResultComment>
     */
    #[ORM\OneToMany(targetEntity: ResultComment::class, mappedBy: 'User', orphanRemoval: true)]
    private Collection $resultComments;

    public function __construct()
    {
        $this->gnosisEntries = new ArrayCollection();
        $this->resultComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;
        
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $Email): static
    {
        $this->email = $Email;
        
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $Password): static
    {
        $this->password = $Password;
        
        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    /**
     * To clarify: I had to implement this due to the Interface by Symfony but I had an idea on how to work with the Role idea partially implemented.
     * We'll see how much it will develop further, but for now this satisfies the Interface requirements.
     * */
    public function getRoles(): array
    {
        return [$this->getRole()->getTitle()];
    }

    public function setRole(?Role $Role): static
    {
        $this->role = $Role;
        
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Do nothing... for now...
        // Why do I need this?
    }

    public function getUserIdentifier(): string
    {
        return $this->getUsername();
    }

    /**
     * @return Collection<int, GnosisEntry>
     */
    public function getGnosisEntries(): Collection
    {
        return $this->gnosisEntries;
    }

    public function addGnosisEntry(GnosisEntry $gnosisEntry): static
    {
        if (!$this->gnosisEntries->contains($gnosisEntry)) {
            $this->gnosisEntries->add($gnosisEntry);
            $gnosisEntry->setUser($this);
        }

        return $this;
    }

    public function removeGnosisEntry(GnosisEntry $gnosisEntry): static
    {
        if ($this->gnosisEntries->removeElement($gnosisEntry)) {
            // set the owning side to null (unless already changed)
            if ($gnosisEntry->getUser() === $this) {
                $gnosisEntry->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ResultComment>
     */
    public function getResultComments(): Collection
    {
        return $this->resultComments;
    }

    public function addResultComment(ResultComment $resultComment): static
    {
        if (!$this->resultComments->contains($resultComment)) {
            $this->resultComments->add($resultComment);
            $resultComment->setUser($this);
        }

        return $this;
    }

    public function removeResultComment(ResultComment $resultComment): static
    {
        if ($this->resultComments->removeElement($resultComment)) {
            // set the owning side to null (unless already changed)
            if ($resultComment->getUser() === $this) {
                $resultComment->setUser(null);
            }
        }

        return $this;
    }
}
