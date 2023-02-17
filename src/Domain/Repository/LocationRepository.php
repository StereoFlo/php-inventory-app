<?php declare(strict_types = 1);

namespace App\Domain\Repository;

use App\Domain\Entity\Location;

interface LocationRepository
{
    /**
     * @return Location[]|null
     */
    public function getFirstLevel(): ?array;
    public function getById(int $id) : ?Location;

    /**
     * @param int[] $ids
     * @return Location[]|null
     */
    public function getByIds(array $ids): ?array;
    public function save(Location $location): void;
}