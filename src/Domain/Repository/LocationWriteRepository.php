<?php declare(strict_types = 1);

namespace App\Domain\Repository;

use App\Domain\Entity\Location;

interface LocationWriteRepository
{
    public function save(Location $location): void;
}