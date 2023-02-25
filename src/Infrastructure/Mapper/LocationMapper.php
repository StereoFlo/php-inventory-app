<?php declare(strict_types = 1);

namespace App\Infrastructure\Mapper;

use App\Domain\Entity\Location;
use function array_map;

class LocationMapper
{
    /**
     * @return array<string, mixed>
     */
    public function map(Location $location): array
    {
        return [
            'id'   => $location->getId(),
            'name' => $location->getName(),
        ];
    }

    /**
     * @param Location[] $locations
     * @return array<array<string, mixed>>
     */
    public function mapCollection(array $locations): array
    {
        if (empty($locations)) {
            return [];
        }

        /** @var array<array<string, mixed>> $res */
        $res = array_map([$this, 'map'], $locations);

        return $res;
    }
}