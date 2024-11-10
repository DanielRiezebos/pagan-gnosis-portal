<?php

namespace App\Entity;

use App\Repository\GnosisEntryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GnosisEntryRepository::class)]
class GnosisEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'gnosisEntries')]
    #[ORM\JoinColumn(name: 'gnosisproject', nullable: false)]
    private ?GnosisProject $gnosisproject = null;

    #[ORM\ManyToOne(inversedBy: 'gnosisEntries')]
    #[ORM\JoinColumn(name: 'user', nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Gnosis = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGnosisProject(): ?GnosisProject
    {
        return $this->gnosisproject;
    }

    public function setGnosisProject(?GnosisProject $gnosisproject): static
    {
        $this->gnosisproject = $gnosisproject;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getGnosis(): ?string
    {
        return $this->Gnosis;
    }

    public function setGnosis(string $Gnosis): static
    {
        $this->Gnosis = $Gnosis;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
