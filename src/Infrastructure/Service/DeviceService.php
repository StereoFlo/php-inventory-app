<?php declare(strict_types = 1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Device;
use App\Domain\Repository\DeviceReadRepository;
use App\Domain\Repository\OutletReadRepository;
use App\Domain\Service\DeviceService as DeviceServiceInterface;
use RuntimeException;
use function count;

class DeviceService implements DeviceServiceInterface
{
    public function __construct(
        private readonly DeviceReadRepository $deviceRepo,
        private readonly OutletReadRepository $outletRepo
    ) {}

    /**
     * @return Device[]
     */
    public function getByLocationId(int $locationId, int $limit, int $offset): array
    {
        return $this->deviceRepo->getByLocationId($locationId, $limit, $offset);
    }

    public function getById(int $id): Device
    {
        $device = $this->deviceRepo->getById($id);
        if (null === $device) {
            throw new RuntimeException(); //todo
        }

        return $device;
    }

    public function getByNameAndIp(string $name, string $ip): Device
    {
        $device = $this->deviceRepo->getByNameAndIp($name, $ip);
        if (null === $device) {
            throw new RuntimeException(); //todo
        }

        return $device;
    }

    /**
     * @param int[]|null $outlets
     */
    public function create(?string $name,
                           ?string $netName,
                           ?string $ip,
                           ?int    $timeToCheck,
                           ?int    $locationId,
                           ?array  $outlets): Device
    {
        $outletsToSave = [];
        if (null !== $outlets && 0 < count($outlets)) {
            $dbOutlets = $this->outletRepo->getByIds($outlets);
            if (null !== $dbOutlets) {
                $outletsToSave = $dbOutlets;
            }
        }
        $device = new Device(
            $name,
            $netName,
            $ip,
            $timeToCheck,
            $locationId,
            $outletsToSave,
        );
        $this->deviceRepo->save($device);

        return $device;
    }
}