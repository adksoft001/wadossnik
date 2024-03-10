<?php

namespace App\Service;

use App\Contracts\AddTextInterface;
use App\Contracts\TextHandleServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

abstract class AddTextService implements AddTextInterface
{
    public function __construct(
        protected TextHandleServiceInterface $textHandleService,
        protected  EntityManagerInterface $entityManager,
    )
    {
    }
}