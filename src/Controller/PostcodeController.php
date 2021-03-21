<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostcodeController extends AbstractController
{
    public function findByPartialMatch(string $partial): Response
    {
        return $this->json([
            'partial' => $partial,
        ]);
    }

    public function findByLocation(float $lat, float $long, float $range): Response
    {
        return $this->json([
            'lat' => $lat,
            'long' => $long,
            'range' => $range,
        ]);
    }
}
