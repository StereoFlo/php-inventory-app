<?php declare(strict_types = 1);

namespace App\Infrastructure\Mapper;

use App\Domain\Entity\Outlet;
use function array_map;

class OutletMapper
{
    /**
     * @return array<string, mixed>
     */
    public function map(Outlet $outlet): array
    {
        return [
            'id'          => $outlet->getId(),
            'name'        => $outlet->getName(),
            'location_id' => $outlet->getLocationId(),
        ];
    }

    /**
     * @param Outlet[] $outlets
     * @return array<array<string, mixed>>
     */
    public function mapCollection(array $outlets): array
    {
        return array_map([$this, 'map'], $outlets);
    }
}