<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function index(
        BrandRepository   $brandRepository,
    ): Response
    {
        $brands = $brandRepository->createQueryBuilder('b')
            ->orderBy('b.order', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('index/index.html.twig', [
            'brands' => $brands,
        ]);
    }
}