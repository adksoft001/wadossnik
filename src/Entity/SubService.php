<?php

namespace App\Entity;

use App\Repository\SubServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubServiceRepository::class)]
class SubService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'subServices')]
    private Service $service;

    #[ORM\Column(length: 255)]
    private string $name = '';

    #[ORM\Column(length: 255)]
    private string $slug = '';

    #[ORM\Column]
    private float $hours = 0.0;

    #[ORM\Column(type: Types::TEXT)]
    private string $seo_text = '';

    #[ORM\OneToMany(mappedBy: 'sub_service', targetEntity: ChildService::class)]
    private Collection $childServices;

    public function __construct()
    {
        $this->childServices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getService(): Service
    {
        return $this->service;
    }

    public function setService(Service $service): self
    {
        $this->service = $service;

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

    /**
     * @return Collection<int, ChildService>
     */
    public function getChildServices(): Collection
    {
        return $this->childServices;
    }

    public function addChildService(ChildService $childService): self
    {
        if (!$this->childServices->contains($childService)) {
            $this->childServices->add($childService);
            $childService->setSubService($this);
        }

        return $this;
    }

    public function removeChildService(ChildService $childService): self
    {
        if ($this->childServices->removeElement($childService)) {
            // set the owning side to null (unless already changed)
            if ($childService->getSubService() === $this) {
                $childService->setSubService(null);
            }
        }

        return $this;
    }
}
