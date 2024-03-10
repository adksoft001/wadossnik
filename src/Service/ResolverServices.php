<?php

namespace App\Service;

use App\Contracts\ResolverServicesInterface;
use App\Entity\Brand;
use App\Entity\ChildService;
use App\Entity\Model;
use App\Entity\Service;
use App\Entity\SubService;
use App\Repository\BrandRepository;
use App\Repository\ChildServiceRepository;
use App\Repository\ModelRepository;
use App\Repository\ServiceRepository;
use App\Repository\SubServiceRepository;

class ResolverServices implements ResolverServicesInterface
{
    public function __construct(
        private ServiceRepository      $serviceRepository,
        private SubServiceRepository   $subServiceRepository,
        private ChildServiceRepository $childServiceRepository,
        private BrandRepository        $brandRepository,
        private ModelRepository        $modelRepository
    )
    {
    }

    public function getService($token): Service|SubService|ChildService|null
    {
        return $this->serviceRepository->findOneBy(['slug' => str_replace('/', '', $token)])
            ?? $this->subServiceRepository->findOneBy(['slug' => $token])
            ?? $this->childServiceRepository->findOneBy(['slug' => $token]);
    }

    public function getBrand($token): Brand|null
    {
        $hostName = preg_replace('/\.[a-z]+/', '', $_SERVER['HTTP_HOST']);

        if (substr_count($hostName, '-') < 2) {
            $brandUrl = preg_replace('[^[a-z]+-[a-z]+-]', '', rtrim($token, '/'));
        } else {
            $brandUrl = preg_replace('[^[a-z]+-[a-z]+-[a-z]+-]', '', rtrim($token, '/'));
        }

        return $this->brandRepository->findOneBy(['url' => $brandUrl]);
    }

    public function getServiceBrand($token): array
    {
        [$brandUrl, $serviceSlug] = explode('/', $token);

        return [
            'service' => $this->serviceRepository->findOneBy(['slug' => $serviceSlug])
                ?? $this->subServiceRepository->findOneBy(['slug' => $serviceSlug . '/'])
                    ?? $this->childServiceRepository->findOneBy(['slug' => $serviceSlug . '/']),
            'brand' => $this->brandRepository->findOneBy(['url' => $brandUrl])
        ];
    }

    public function getModel($token): Model|null
    {

        if (substr_count($token, '/') > 2) {
            return null;
        }

        list($brandSlug, $modelSlug) = explode('/', $token);
        $hostName = preg_replace('/\.[a-z]+/', '', $_SERVER['HTTP_HOST']);
        $modelName = str_replace(str_replace($hostName . '-', '', $brandSlug) . '-', '', $modelSlug);

        if (substr_count($hostName, '-') < 2) {
            $brandUrl = preg_replace('[^[a-z]+-[a-z]+-]', '', $brandSlug);
        } else {
            $brandUrl = preg_replace('[^[a-z]+-[a-z]+-[a-z]+-]', '', $brandSlug);
        }

        $brand = $this->brandRepository->findOneBy(['url' => $brandUrl]);

        return $this->modelRepository->findOneBy(['url' => $modelName, 'brand' => $brand]);
    }

    public function getServiceModel($token): ?array
    {
        $settingsModel = explode('/', $token);
        $valuesSettingsModel = array_filter($settingsModel, 'strlen');
        $hostName = preg_replace('/\.[a-z]+/', '', $_SERVER['HTTP_HOST']);

        if (count($valuesSettingsModel) >= 3 and end($valuesSettingsModel)) {
            list($brandSlug, $modelSlug, $serviceSlug) = $settingsModel;
        } else {
            return null;
        }
        $modelName = str_replace(str_replace($hostName . '-', '', $brandSlug) . '-', '', $modelSlug);

        if (substr_count($hostName, '-') < 2) {
            $brandUrl = preg_replace('[^[a-z]+-[a-z]+-]', '', $brandSlug);
        } else {
            $brandUrl = preg_replace('[^[a-z]+-[a-z]+-[a-z]+-]', '', $brandSlug);
        }

        $brand = $this->brandRepository->findOneBy(['url' => $brandUrl]);

        return [
            'service' => $this->serviceRepository->findOneBy(['slug' => $serviceSlug])
                ?? $this->subServiceRepository->findOneBy(['slug' => $serviceSlug . '/'])
                    ?? $this->childServiceRepository->findOneBy(['slug' => $serviceSlug . '/']),
            'model' => $this->modelRepository->findOneBy(['url' => $modelName, 'brand' => $brand])
        ];
    }
}