<?php

namespace App\Controller;

use App\Repository\PostcodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostcodeController extends AbstractController
{
    public function findByPartialMatch(
        PostcodeRepository $repository,
        string $partial
    ): Response {
        return $this->json($repository->findByPartialMatch($partial));
    }

    public function findByLocation(
        PostcodeRepository $repository,
        float $lat,
        float $long,
        float $range
    ): Response {
        return $this->json($repository->findByLocation($lat, $long, $range));
    }
}
