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
    #[ORM\JoinColumn(nullable: false)]
    private ?GnosisProject $gnosisproject_id = null;

    #[ORM\ManyToOne(inversedBy: 'gnosisEntries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Gnosis = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGnosisprojectId(): ?GnosisProject
    {
        return $this->gnosisproject_id;
    }

    public function setGnosisprojectId(?GnosisProject $gnosisproject_id): static
    {
        $this->gnosisproject_id = $gnosisproject_id;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

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
