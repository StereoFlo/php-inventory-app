<?php declare(strict_types = 1);

namespace App\Domain\Repository;

use App\Domain\Entity\Device;

interface DeviceRepository
{
    public function getByLocationId(int $locationId, int $limit, int $offset): ?Device;

    public function getById(int $id): ?Device;

    /**
     * @param array<int> $ids
     * @return Device[]|null
     */
    public function getByIds(array $ids): ?array;

    public function getByNameAndIp(string $name, string $ip): ?Device;

    public function save(Device $device): void;
}