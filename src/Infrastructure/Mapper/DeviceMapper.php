<?php declare(strict_types = 1);

namespace App\Infrastructure\Mapper;

use App\Domain\Entity\Device;
use App\Domain\Entity\Location;
use App\Domain\Entity\Outlet;
use function array_map;

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
     * @param Device[] $devices
     * @return array<array<string, mixed>>
     */
    public function mapCollection(array $devices): array
    {
        if (empty($devices)) {
            return [];
        }

        /** @var array<array<string, mixed>> $res */
        $res = array_map([$this, 'map'], $devices);

        return $res;
    }
}