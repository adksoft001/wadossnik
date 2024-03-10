<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name = '';

    #[ORM\Column(length: 255)]
    private string $slug = '';

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: SubService::class)]
    private Collection $subServices;

    #[ORM\Column]
    private bool $is_domain = true;

    #[ORM\Column(type: Types::TEXT)]
    private string $seo_text = '';

    #[ORM\Column]
    private int $order_by_remont_forsunki = 0;

    #[ORM\Column]
    private int $order_by_remont_dizelnogo_dvigatelya = 0;

    #[ORM\Column]
    private int $order_by_wadossnk = 0;

    #[ORM\Column]
    private int $order_by_remont_tnvd = 0;

    #[ORM\Column]
    private int $order_by_remont_turbiny = 0;

    #[ORM\Column]
    private int $order_by_remont_rulevyh_reek = 0;

    #[ORM\Column]
    private int $order_by_remont_avtokondicionerov = 0;

    #[ORM\Column]
    private int $order_by_tehnicheskoe_obsluzhivanie = 0;

    #[ORM\Column]
    private int $order_by_remont_akpp_moskva = 0;

    public function __construct()
    {
        $this->subServices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, SubService>
     */
    public function getSubServices(): Collection
    {
        return $this->subServices;
    }

    public function addSubService(SubService $subService): self
    {
        if (!$this->subServices->contains($subService)) {
            $this->subServices->add($subService);
            $subService->setService($this);
        }

        return $this;
    }

    public function removeSubService(SubService $subService): self
    {
        if ($this->subServices->removeElement($subService)) {
            // set the owning side to null (unless already changed)
            if ($subService->getService() === $this) {
                $subService->setService(null);
            }
        }

        return $this;
    }

    public function isIsDomain(): bool
    {
        return $this->is_domain;
    }

    public function setIsDomain(bool $is_domain): self
    {
        $this->is_domain = $is_domain;

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

    public function getOrderByRemontForsunki(): int
    {
        return $this->order_by_remont_forsunki;
    }

    public function setOrderByRemontForsunki(int $order_by_remont_forsunki): self
    {
        $this->order_by_remont_forsunki = $order_by_remont_forsunki;

        return $this;
    }

    public function getOrderByRemontDizelnogoDvigatelya(): int
    {
        return $this->order_by_remont_dizelnogo_dvigatelya;
    }

    public function setOrderByRemontDizelnogoDvigatelya(int $order_by_remont_dizelnogo_dvigatelya): self
    {
        $this->order_by_remont_dizelnogo_dvigatelya = $order_by_remont_dizelnogo_dvigatelya;

        return $this;
    }

    public function getOrderByRemontDvigatelya(): int
    {
        return $this->order_by_remont_dvigatelya;
    }

    public function setOrderByRemontDvigatelya(int $order_by_remont_dvigatelya): self
    {
        $this->order_by_remont_dvigatelya = $order_by_remont_dvigatelya;

        return $this;
    }

    public function getOrderByRemontTnvd(): int
    {
        return $this->order_by_remont_tnvd;
    }

    public function setOrderByRemontTnvd(int $order_by_remont_tnvd): self
    {
        $this->order_by_remont_tnvd = $order_by_remont_tnvd;

        return $this;
    }

    public function getOrderByRemontTurbiny(): int
    {
        return $this->order_by_remont_turbiny;
    }

    public function setOrderByRemontTurbiny(int $order_by_remont_turbiny): self
    {
        $this->order_by_remont_turbiny = $order_by_remont_turbiny;

        return $this;
    }

    public function getOrderByRemontRulevyhReek(): int
    {
        return $this->order_by_remont_rulevyh_reek;
    }

    public function setOrderByRemontRulevyhReek(int $order_by_remont_rulevyh_reek): self
    {
        $this->order_by_remont_rulevyh_reek = $order_by_remont_rulevyh_reek;

        return $this;
    }

    public function getOrderByRemontAvtokondicionerov(): int
    {
        return $this->order_by_remont_avtokondicionerov;
    }

    public function setOrderByRemontAvtokondicionerov(int $order_by_remont_avtokondicionerov): self
    {
        $this->order_by_remont_avtokondicionerov = $order_by_remont_avtokondicionerov;

        return $this;
    }

    public function getOrderByRemontAkppMoskva(): ?int
    {
        return $this->order_by_remont_akpp_moskva;
    }

    public function setOrderByRemontAkppMoskva(int $order_by_remont_akpp_moskva): self
    {
        $this->order_by_remont_akpp_moskva = $order_by_remont_akpp_moskva;

        return $this;
    }

    public function getOrderByTehnicheskoeObsluzhivanie(): ?int
    {
        return $this->order_by_tehnicheskoe_obsluzhivanie;
    }

    public function setOrderByTehnicheskoeObsluzhivanie(int $order_by_tehnicheskoe_obsluzhivanie): self
    {
        $this->order_by_tehnicheskoe_obsluzhivanie = $order_by_tehnicheskoe_obsluzhivanie;

        return $this;
    }


}
