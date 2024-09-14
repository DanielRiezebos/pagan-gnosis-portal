<?php

namespace App\Entity;

use App\Repository\GnosisProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GnosisProjectRepository::class)]
class GnosisProject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $finished_at = null;

    /**
     * @var Collection<int, GnosisEntry>
     */
    #[ORM\OneToMany(targetEntity: GnosisEntry::class, mappedBy: 'gnosisproject_id', orphanRemoval: true)]
    private Collection $gnosisEntries;

    public function __construct()
    {
        $this->gnosisEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getFinishedAt(): ?\DateTimeImmutable
    {
        return $this->finished_at;
    }

    public function setFinishedAt(?\DateTimeImmutable $finished_at): static
    {
        $this->finished_at = $finished_at;

        return $this;
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
            $gnosisEntry->setGnosisprojectId($this);
        }

        return $this;
    }

    public function removeGnosisEntry(GnosisEntry $gnosisEntry): static
    {
        if ($this->gnosisEntries->removeElement($gnosisEntry)) {
            // set the owning side to null (unless already changed)
            if ($gnosisEntry->getGnosisprojectId() === $this) {
                $gnosisEntry->setGnosisprojectId(null);
            }
        }

        return $this;
    }
}
