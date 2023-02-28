<?php declare(strict_types = 1);

namespace App\Infrastructure\Mapper;

use App\Domain\Entity\Device;
use App\Domain\Entity\Location;
use App\Domain\Entity\Outlet;

class DeviceMapper
{
    public function __construct(private readonly OutletMapper $outletMapper) {}

    /**
     * @return array<string, mixed>
     */
    public function map(Device $device): array
    {
        $res = [
            'id'          => $device->getId(),
            'name'        => $device->getName(),
            'ip'          => $device->getIp(),
            'net_name'    => $device->getNetName(),
            'timeToCheck' => $device->getTimeToCheck(),
            'location_id' => $device->getLocationId(),
            'outlets'     => null,
        ];

        $outlets = $device->getOutlets();
        if (!$outlets->isEmpty()) {
            /** @var Outlet[] $arr */
            $arr            = $outlets->toArray();
            $res['outlets'] = $this->outletMapper->mapCollection($arr);
        }

        return $res;
    }

    /**
     * @param array<Location> $locations
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