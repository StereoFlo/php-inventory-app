<?php declare(strict_types = 1);

namespace App\Controller;

use App\Domain\Service\LocationService;
use App\Infrastructure\Mapper\LocationMapper;
use App\Infrastructure\Responder\Responder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/locations', name: 'locationsList', methods: [Request::METHOD_GET])]
class LocationFirstLevelController
{
    public function __construct(
        private readonly LocationService $locationService,
        private readonly Responder $responder,
        private readonly LocationMapper $mapper
    ) {}

    public function __invoke(): Response
    {
        $list = $this->locationService->getFirstLevel();

        return $this->responder->successList($this->mapper->mapCollection($list), 0, 0, 0);
    }
}