<?php

namespace App\Entity;

use App\Repository\ChildServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChildServiceRepository::class)]
class ChildService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'childServices')]
    private ?SubService $sub_service = null;

    #[ORM\Column(length: 255)]
    private string $name = '';

    #[ORM\Column(length: 255)]
    private string $slug = '';

    #[ORM\Column]
    private float $hours = 0.0;

    #[ORM\Column(type: Types::TEXT)]
    private string $seo_text = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubService(): ?SubService
    {
        return $this->sub_service;
    }

    public function setSubService(?SubService $sub_service): self
    {
        $this->sub_service = $sub_service;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getHours(): float
    {
        return $this->hours;
    }

    public function setHours(float $hours): self
    {
        $this->hours = $hours;

        return $this;
    }

    public function getSeoText(): string
    {
        return $this->seo_text;
    }

    public function setSeoText(string $seo_text): self
    {
        $this->seo_text = $seo_text;

        return $this;
    }
}
