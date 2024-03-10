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
    public function get_all_services(bool $is_main_site = true): array
    {
        $hostName = preg_replace('/\.[a-z]+/', '', $_SERVER['HTTP_HOST']);
        $fieldName = str_replace('-', '_', 's.order_by_' . $hostName);

        $qb = $this->serviceRepository->createQueryBuilder('s');

        $services = $qb
            ->orderBy($fieldName, 'ASC');

        if (!$is_main_site) {
            $services = $qb
                ->andWhere('s.is_domain =:is_domain')
                ->andWhere($qb->expr()->notIn('s.slug', [$hostName]))
                ->setParameter('is_domain', true)
                ->orderBy($fieldName, 'ASC');
        }

        return $services
            ->getQuery()
            ->getResult();
    }

    /**
     * Получить объект услуги по домену для сетки сайтов
     *
     * @return Service|null
     */
    public function get_service_from_domain(): ?Service
    {
        $hostName = preg_replace('/\.[a-z]+/', '', $_SERVER['HTTP_HOST']);

        return $this->serviceRepository->findOneBy(['slug' => $hostName]);
    }

    /**
     * Получить текущий объект услуги, дочерней услуги
     */
    public function get_current_service(SubService|ChildService|Service $service): Service|SubService|ChildService|null
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
    public function get_services_for_price_list(SubService|ChildService|Service $service): PersistentCollection|null
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

    public function get_service(string $slug): ?Service
    {
        return $this->serviceRepository->findOneBy(['slug' => $slug]);
    }
}