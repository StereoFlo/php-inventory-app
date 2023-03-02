<?php declare(strict_types = 1);

namespace App\Domain\Service;

use App\Domain\Entity\Location;

interface LocationService
{
    /**
     * @return Location[]
     */
    public function getFirstLevel(): array;

    public function getById(int $id): Location;

    /**
     * @param int[] $ids
     * @return Location[]
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