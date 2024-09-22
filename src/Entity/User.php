<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Username = null;

    #[ORM\Column(length: 255)]
    private ?string $Password = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $Role = null;

    /**
     * @var Collection<int, GnosisEntry>
     */
    #[ORM\OneToMany(targetEntity: GnosisEntry::class, mappedBy: 'user_id', orphanRemoval: true)]
    private Collection $gnosisEntries;

    public function __construct()
    {
        $this->gnosisEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(string $Username): static
    {
        $this->Username = $Username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): static
    {
        $this->Password = $Password;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->Role;
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
        $this->Role = $Role;

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
            $gnosisEntry->setUserId($this);
        }

        return $this;
    }

    public function removeGnosisEntry(GnosisEntry $gnosisEntry): static
    {
        if ($this->gnosisEntries->removeElement($gnosisEntry)) {
            // set the owning side to null (unless already changed)
            if ($gnosisEntry->getUserId() === $this) {
                $gnosisEntry->setUserId(null);
            }
        }

        return $this;
    }
}
