<?php

namespace App\Twig;

use App\Repository\PromoRepository;
use Twig\Extension\RuntimeExtensionInterface;

class PromoRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private PromoRepository $promoRepository
    )
    {
    }
    public function get_all_promo(): array
    {
        return $this->promoRepository->findAll();
    }

}