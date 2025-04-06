<?php

namespace App\Entity;

use App\Repository\ResultCommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultCommentRepository::class)]
class ResultComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'resultComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GnosisProject $GnosisProject = null;

    #[ORM\ManyToOne(inversedBy: 'resultComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\OneToOne(targetEntity: self::class, cascade: ['persist', 'remove'])]
    private ?self $ParentComment = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    // #[ORM\OneToOne(targetEntity: self::class, mappedBy: 'ResultComment', cascade: ['persist', 'remove'])]
    // private ?self $resultComment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGnosisProject(): ?GnosisProject
    {
        return $this->GnosisProject;
    }

    public function setGnosisProject(?GnosisProject $GnosisProject): static
    {
        $this->GnosisProject = $GnosisProject;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->ParentComment;
    }

    public function setParent(?self $ParentComment): static
    {
        $this->ParentComment = $ParentComment;

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
