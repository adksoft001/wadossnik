<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SimplePageController extends AbstractController
{
    #[Route('/services', name: 'services')]
    public function services(): Response
    {
        return $this->render('services/index.html.twig');
    }

    #[Route('/price_list', name: 'price_list')]
    public function priceList(): Response
    {
        return $this->render('static_page/price_list.html.twig');
    }

    #[Route('/contacts', name: 'contacts')]
    public function contacts(): Response
    {
        return $this->render('static_page/contacts.html.twig');
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('static_page/about.html.twig');
    }
}
