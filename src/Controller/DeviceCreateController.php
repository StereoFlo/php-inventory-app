<?php declare(strict_types = 1);

namespace App\Controller;

use App\Domain\Entity\Device;
use App\Domain\Repository\DeviceRepository;
use App\Infrastructure\Dto\DeviceCreateDto;
use App\Infrastructure\Mapper\DeviceMapper;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeviceCreateController
{
    public function __construct(private readonly DeviceRepository $deviceService, private readonly DeviceMapper $mapper)
    {
    }

    public function __invoke(DeviceCreateDto $dto): JsonResponse
    {
        $e = new Device($dto->getName(),
            $dto->getNetName(),
            $dto->getIp(),
            $dto->getTimeToCheck(),
            $dto->getLocationId(),
            $dto->getOutlets()
        );
        $this->deviceService->save($e);

        return new JsonResponse($this->mapper->map($e));
    }
}