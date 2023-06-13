<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Domain\Service\DeviceService;
use App\Infrastructure\Mapper\DeviceMapper;
use App\Infrastructure\Responder\Responder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function count;

#[Route('/locations/{locationId}/devices', name: 'locationDevices', requirements: ['locationId' => '\d+'], methods: [Request::METHOD_GET])]
class LocationDevices
{
    public function __construct(
        private readonly DeviceService $deviceService,
        private readonly DeviceMapper $mapper,
        private readonly Responder $responder
    ) {}

    public function __invoke(Request $request, int $locationId): Response
    {
        $limit   = $request->query->getInt('limit', 10);
        $offset  = $request->query->getInt('offset');
        $devices = $this->deviceService->getByLocationId($locationId, $limit, $offset);
        $res     = $this->mapper->mapCollection($devices);

        return $this->responder->successList($res, count($res), $limit, $offset); //todo
    }
}