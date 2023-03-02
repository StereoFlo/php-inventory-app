<?php declare(strict_types = 1);

namespace App\Controller;

use App\Domain\Service\DeviceService;
use App\Infrastructure\Dto\DeviceCreateDto;
use App\Infrastructure\Mapper\DeviceMapper;
use App\Infrastructure\Responder\Responder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/devices', name: 'deviceCreate', methods: [Request::METHOD_POST])]
class DeviceCreateController
{
    public function __construct(
        private readonly DeviceService $deviceService,
        private readonly Responder $responder,
        private readonly DeviceMapper $mapper
    ) {}

    public function __invoke(DeviceCreateDto $dto): Response
    {
        $e = $this->deviceService->create($dto->getName(),
            $dto->getNetName(),
            $dto->getIp(),
            $dto->getTimeToCheck(),
            $dto->getLocationId(),
            $dto->getOutlets());

        return $this->responder->success($this->mapper->map($e));
    }
}