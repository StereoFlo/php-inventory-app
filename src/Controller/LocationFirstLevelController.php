<?php declare(strict_types = 1);

namespace App\Controller;

use App\Domain\Service\LocationService;
use App\Infrastructure\Mapper\LocationMapper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/locations', name: 'locationsList', methods: [Request::METHOD_GET])]
class LocationFirstLevelController
{
    public function __construct(
        private readonly LocationService $locationService,
        private readonly LocationMapper $mapper
    ) {}

    public function __invoke(): JsonResponse
    {
        $list = $this->locationService->getFirstLevel();

        return new JsonResponse($this->mapper->mapCollection($list));
    }
}