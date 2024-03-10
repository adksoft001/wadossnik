<?php

namespace App\Service;

use App\Contracts\TextHandleServiceInterface;
use App\Entity\ChildService;
use App\Entity\Service;
use App\Entity\SubService;
use App\Repository\ChildServiceRepository;
use App\Repository\ServiceRepository;
use App\Repository\SubServiceRepository;
use Doctrine\ORM\EntityManagerInterface;

class AddSeoTextService extends AddTextService
{

    public function __construct(
        TextHandleServiceInterface     $textHandleService,
        EntityManagerInterface         $entityManager,
        private SubServiceRepository   $subServiceRepository,
        private ServiceRepository      $serviceRepository,
        private ChildServiceRepository $childServiceRepository,

    )
    {
        parent::__construct($textHandleService, $entityManager);
    }

    public function add(string $fileName): void
    {
        $arrText = $this->textHandleService->readDoc($fileName, 'articles');

        $nameArticle = preg_replace('/\*\*\*h1\.\s*/', '', $arrText[0]);

        $service = $this->serviceRepository->findOneBy(['name' => $nameArticle])
            ?? $this->subServiceRepository->findOneBy(['name' => $nameArticle])
            ?? $this->childServiceRepository->findOneBy(['name' => $nameArticle]);

        if ($service instanceof Service) {
            $service->setSeoText($this->textHandleService->handleText($arrText));
        }

        if ($service instanceof SubService) {
            $service->setSeoText($this->textHandleService->handleText($arrText));
        }

        if ($service instanceof ChildService) {
            $service->setSeoText($this->textHandleService->handleText($arrText));
        }

        $this->entityManager->flush();

        $dir = getcwd() . '/articles/';
        unlink($dir. $fileName);
    }

}