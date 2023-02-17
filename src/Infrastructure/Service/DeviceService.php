<?php declare(strict_types = 1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Device;
use App\Domain\Repository\DeviceRepository;

class DeviceService implements DeviceRepository
{
    public function __construct(private readonly DeviceRepository $deviceRepository) {}

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

    public function save(Device $device): void
    {
        $this->deviceRepository->save($device);
    }
}