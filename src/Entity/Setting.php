<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingsRepository::class)]
class Setting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $SettingKey = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $SettingValue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSettingKey(): ?string
    {
        return $this->SettingKey;
    }

    public function setSettingKey(string $SettingKey): static
    {
        $this->SettingKey = $SettingKey;

        return $this;
    }

    public function getSettingValue(): ?string
    {
        return $this->SettingValue;
    }

    public function setSettingValue(?string $SettingValue): static
    {
        $this->SettingValue = $SettingValue;

        return $this;
    }
}
