<?php declare(strict_types = 1);

namespace App\Controller;

use App\Domain\Service\DeviceService;
use App\Infrastructure\Mapper\DeviceMapper;
use App\Infrastructure\Responder\Responder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/devices/{id}', name: 'deviceList', requirements: ['id' => '\d+'], methods: [Request::METHOD_GET])]
class DeviceDetailController
{
    public function __construct(
        private readonly DeviceService $deviceService,
        private readonly DeviceMapper $mapper,
        private readonly Responder $responder
    ) {}

    public function __invoke(int $id): Response
    {
        $data = $this->deviceService->getById($id);

        return $this->responder->success($this->mapper->map($data));
    }
}