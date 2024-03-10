<?php

namespace App\Twig;

use App\Entity\ChildService;
use App\Entity\Service;
use App\Entity\SubService;
use App\Repository\ServiceRepository;
use Doctrine\ORM\PersistentCollection;
use Twig\Extension\RuntimeExtensionInterface;

class ServiceRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private ServiceRepository $serviceRepository,
    )
    {
    }

    /**
     * Получить все услуги,
     * если $is_service_from_domain = true, получить дочерние услуги у спец.сайта
     */
    public function get_all_services(): array
    {
        $qb = $this->serviceRepository->createQueryBuilder('s');

        return $qb
            ->orderBy('s.orderBy', 'ASC')
            ->getQuery()
            ->getResult();
    }


    /**
     * Получить текущий объект услуги, дочерней услуги
     */
    public
    function get_current_service(SubService|ChildService|Service $service): Service|SubService|ChildService|null
    {
        if ($service instanceof SubService) {
            if ($service->getChildServices()->count()) {
                return $service;
            }
            return $service->getService();
        }

        if ($service instanceof ChildService) {
            return $service->getSubService();
        }

        if ($service instanceof Service) {
            return $service;
        }

        return null;
    }

    /**
     * Получить дочерние услуги у родительской услуги
     */
    public
    function get_services_for_price_list(SubService|ChildService|Service $service): PersistentCollection|null
    {
        if ($service instanceof SubService) {
            if ($service->getChildServices()->count()) {
                return $service->getChildServices();
            }
            return $service->getService()->getSubServices();
        }

        if ($service instanceof ChildService) {
            return $service->getSubService()->getChildServices();
        }

        if ($service instanceof Service) {
            return $service->getSubServices();
        }

        return null;
    }

    public
    function get_service(string $slug): ?Service
    {
        return $this->serviceRepository->findOneBy(['slug' => $slug]);
    }
}