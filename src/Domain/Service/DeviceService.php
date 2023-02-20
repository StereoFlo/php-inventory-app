<?php declare(strict_types = 1);

namespace App\Domain\Service;

use App\Domain\Entity\Device;

interface DeviceService
{
    public function getByLocationId(int $locationId, int $limit, int $offset): ?Device;

    public function getById(int $id): ?Device;

    public function getByNameAndIp(string $name, string $ip): ?Device;

    /**
     * @return array<string, mixed>
     */
    public function save(
        ?string $name,
        ?string $netName,
        ?string $ip,
        ?int $timeToCheck,
        ?int $locationId,
        ?array $outlets
    ): array;
}