<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\ChildService;
use App\Entity\Model;
use App\Entity\Service;
use App\Entity\SubService;
use App\Service\ResolverServices;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/{token}', name: 'dynamic_pages', requirements: ["token" => ".+\/$"], priority: -1)]
    public function renderPage(
        string $token,
        ResolverServices $resolverServices,
    ): Response {
        $service = $resolverServices->getService($token);

        if ($service) {
            return $this->renderService($service);
        }

        $modelService = $resolverServices->getServiceModel($token);

        if ($modelService && !in_array(null, $modelService)) {
            return $this->renderServiceModel($modelService);
        }

        $model = $resolverServices->getModel($token);

        if ($model) {
            return $this->model($model);
        }

        $brand = $resolverServices->getBrand($token);

        if ($brand) {
            return $this->brand($brand);
        }

        $serviceBrand = $resolverServices->getServiceBrand($token);

        if ($serviceBrand && !in_array(null, $serviceBrand)) {
            return $this->renderServiceBrand($serviceBrand);
        }


        throw $this->createNotFoundException('The service does not exist');
    }

    private function renderService($service): Response
    {
        if (!($service instanceof Service) &&
            !($service instanceof SubService) &&
            !($service instanceof ChildService)) {
            throw new InvalidArgumentException('Invalid service type provided');
        }

        return $this->render('services/page_service.html.twig', [
            'service' => $service,
        ]);
    }

    private function brand(Brand $brand): Response
    {
        return $this->render('brands/page_brand.html.twig', [
            'brand' => $brand,
        ]);
    }

    private function renderServiceBrand(array $serviceBrand): Response
    {
        return $this->render('brands/page_brand_service.html.twig', [
            'brand'   => $serviceBrand['brand'],
            'service' => $serviceBrand['service']
        ]);
    }

    private function model(Model $model): Response
    {
        return $this->render('model/page_model.html.twig', [
            'model' => $model,
        ]);
    }

    private function renderServiceModel(array $serviceModel): Response
    {
        return $this->render('model/page_model_service.html.twig', [
            'model'   => $serviceModel['model'],
            'service' => $serviceModel['service'],
        ]);
    }
}
