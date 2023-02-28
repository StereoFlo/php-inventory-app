<?php declare(strict_types = 1);

namespace App\Domain\Service;

use App\Domain\Entity\Location;

interface LocationService
{
    /**
     * @return array<array<string, mixed>>
     */
    public function getFirstLevel(): array;

    /**
     * @return array<string, mixed>
     */
    public function getById(int $id) : array;

    /**
     * @param int[] $ids
     * @return array<array<string, mixed>>
     */
    public function getByIds(array $ids): array;

    /**
     * @param int[] $childrenIds
     * @param int[] $deviceIds
     * @param int[] $outletsIds
     */
    public function create(
        string $name,
        string $type,
        ?int $locationId,
        array $childrenIds = [],
        array $deviceIds = [],
        array $outletsIds = []
    ): void;
}