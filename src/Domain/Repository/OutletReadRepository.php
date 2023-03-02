<?php declare(strict_types = 1);

namespace App\Domain\Repository;

use App\Domain\Entity\Outlet;

interface OutletReadRepository
{
    public function getById(int $id): ?Outlet;

    /**
     * @param int[] $ids
     * @return Outlet[]|null
     */
    public function getByIds(array $ids): ?array;

    /**
     * @return Outlet[]|null
     */
    public function getByLocationId(int $id): ?array;
}