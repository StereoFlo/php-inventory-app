<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Service\LocationService;
use App\Infrastructure\Mapper\LocationMapper;
use App\Infrastructure\Responder\Responder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/locations/{id}', name: 'locationList', requirements: ['id' => '\d+'], methods: [Request::METHOD_GET])]
class LocationsDetailController
{
    public function __construct(
        private readonly LocationService $locationService,
        private readonly Responder $responder,
        private readonly LocationMapper $mapper
    ) {}

    public function __invoke(int $id): JsonResponse
    {
        $location = $this->locationService->getById($id);

        return $this->responder->success($this->mapper->map($location));
    }
}