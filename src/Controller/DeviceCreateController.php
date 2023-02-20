<?php declare(strict_types = 1);

namespace App\Controller;

use App\Domain\Entity\Device;
use App\Domain\Service\DeviceService;
use App\Infrastructure\Dto\DeviceCreateDto;
use App\Infrastructure\Mapper\DeviceMapper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/devices', name: 'deviceCreate', methods: [Request::METHOD_POST])]
class DeviceCreateController
{
    public function __construct(private readonly DeviceService $deviceService)
    {
    }

    public function __invoke(DeviceCreateDto $dto): JsonResponse
    {
        $e = $this->deviceService->save($dto->getName(),
            $dto->getNetName(),
            $dto->getIp(),
            $dto->getTimeToCheck(),
            $dto->getLocationId(),
            $dto->getOutlets());

        return new JsonResponse($this->mapper->map($e));
    }
}