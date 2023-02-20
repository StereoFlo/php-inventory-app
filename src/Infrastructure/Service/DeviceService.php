<?php declare(strict_types = 1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Device;
use App\Domain\Repository\DeviceRepository;
use App\Domain\Service\DeviceService as DeviceServiceInterface;
use App\Infrastructure\Mapper\DeviceMapper;

class DeviceService implements DeviceServiceInterface
{
    public function __construct(private readonly DeviceRepository $deviceRepository, private readonly DeviceMapper $mapper) {}

    public function getByLocationId(int $locationId, int $limit, int $offset): ?Device
    {
        return $this->deviceRepository->getByLocationId($locationId, $limit, $offset);
    }

    public function getById(int $id): ?Device
    {
        return $this->deviceRepository->getById($id);
    }

    public function getByNameAndIp(string $name, string $ip): ?Device
    {
        return $this->deviceRepository->getByNameAndIp($name, $ip);
    }

    /**
     * @param int[]|null $outlets
     * @return array<string, mixed>
     */
    public function save(?string $name,
                         ?string $netName,
                         ?string $ip,
                         ?int    $timeToCheck,
                         ?int    $locationId,
                         ?array  $outlets): array
    {
        $device = new Device(
            $name,
            $netName,
            $ip,
            $timeToCheck,
            $locationId,
            [], //todo
        );
        $this->deviceRepository->save($device);

        return $this->mapper->map($device);
    }
}