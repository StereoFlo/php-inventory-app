<?php declare(strict_types = 1);

namespace App\Domain\Repository;

use App\Domain\Entity\Outlet;

interface OutletWriteRepository
{
    public function save(Outlet $outlet): void;
}