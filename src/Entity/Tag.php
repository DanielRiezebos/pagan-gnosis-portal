<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, GnosisProject>
     */
    #[ORM\ManyToMany(targetEntity: GnosisProject::class, mappedBy: 'tags')]
    // #[ORM\JoinTable(name: 'gnosis_project_tag')]
    private Collection $GnosisProjects;

    public function __construct()
    {
        $this->GnosisProjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, GnosisProject>
     */
    public function getGnosisProjects(): Collection
    {
        return $this->GnosisProjects;
    }

    public function addGnosisProject(GnosisProject $gnosisProject): static
    {
        if (!$this->GnosisProjects->contains($gnosisProject)) {
            $this->GnosisProjects->add($gnosisProject);
        }

        return $this;
    }

    public function removeGnosisProject(GnosisProject $gnosisProject): static
    {
        $this->GnosisProjects->removeElement($gnosisProject);

        return $this;
    }
}
