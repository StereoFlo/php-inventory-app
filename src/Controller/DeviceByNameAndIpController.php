<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Domain\Service\DeviceService;
use App\Infrastructure\Mapper\DeviceMapper;
use App\Infrastructure\Responder\Responder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/devices/{name}/{ip}', name: 'deviceByNameAndIp', requirements: ['name' => 'a-zA-Z\-_', 'ip' => '^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$'], methods: [Request::METHOD_GET])]
class DeviceByNameAndIpController
{
    public function __construct(
        private readonly DeviceService $deviceService,
        private readonly DeviceMapper $mapper,
        private readonly Responder $responder
    ) {}

    public function __invoke(string $name, string $ip): Response
    {
        $device = $this->deviceService->getByNameAndIp($name, $ip);

        return $this->responder->success($this->mapper->map($device));
    }
}