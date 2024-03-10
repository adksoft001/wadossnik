<?php

namespace App\Contracts;

interface TextHandleServiceInterface
{
    public function readDoc(string $textFile, string $dir): array;

    public function handleText(array $arrayText): string;

}