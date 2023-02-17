<?php declare(strict_types = 1);

namespace App\Infrastructure\Mapper;

use App\Domain\Entity\Device;

class DeviceMapper
{
    public function __construct(private readonly OutletMapper $outletMapper)
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function map(Device $device): array
    {
        return [
            'id'          => $device->getId(),
            'name'        => $device->getName(),
            'ip'          => $device->getIp(),
            'net_name'    => $device->getNetName(),
            'timeToCheck' => $device->getTimeToCheck(),
            'location_id' => $device->getLocationId(),
            'outlets'     => $this->outletMapper->mapCollection($device->getOutlets()),
        ];
    }
}