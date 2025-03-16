<?php

namespace App\Entity;

use App\Entity\User;
use App\Repository\GnosisProjectRepository;
use App\Repository\GnosisEntryRepository;
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
    #[ORM\OneToMany(targetEntity: GnosisEntry::class, mappedBy: 'gnosisproject', orphanRemoval: true, fetch:"EAGER")]
    private Collection $gnosisEntries;

    #[ORM\Column(options: ["default" => false])]
    private ?bool $is_closed;

    /**
     * @var Collection<int, ResultComment>
     */
    #[ORM\OneToMany(targetEntity: ResultComment::class, mappedBy: 'GnosisProject', orphanRemoval: true, fetch:"EAGER")]
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

    public function getEntriesForUser(User $user, GnosisEntryRepository $gnosisEntryRepository) : array {
        return $gnosisEntryRepository->findByUserAndProject($user, $this);
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
            $gnosisEntry->setGnosisproject($this);
        }

        return $this;
    }

    public function removeGnosisEntry(GnosisEntry $gnosisEntry): static
    {
        if ($this->gnosisEntries->removeElement($gnosisEntry)) {
            // set the owning side to null (unless already changed)
            if ($gnosisEntry->getGnosisproject() === $this) {
                $gnosisEntry->setGnosisproject(null);
            }
        }

        return $this;
    }

    public function isClosed(): ?bool
    {
        return $this->is_closed;
    }

    public function setClosed(bool $is_closed): static
    {
        $this->is_closed = $is_closed;

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
            $resultComment->setGnosisProject($this);
        }

        return $this;
    }

    public function removeResultComment(ResultComment $resultComment): static
    {
        if ($this->resultComments->removeElement($resultComment)) {
            // set the owning side to null (unless already changed)
            if ($resultComment->getGnosisProject() === $this) {
                $resultComment->setGnosisProject(null);
            }
        }

        return $this;
    }
}
