<?php declare(strict_types = 1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Device;
use App\Domain\Repository\DeviceRepository;
use App\Domain\Repository\OutletRepository;
use App\Domain\Service\DeviceService as DeviceServiceInterface;
use App\Infrastructure\Mapper\DeviceMapper;
use RuntimeException;
use function count;

class DeviceService implements DeviceServiceInterface
{
    public function __construct(
        private readonly DeviceRepository $deviceRepo,
        private readonly DeviceMapper     $mapper,
        private readonly OutletRepository $outletRepo
    ) {}

    /**
     * @return array<array<string, mixed>>
     */
    public function getByLocationId(int $locationId, int $limit, int $offset): array
    {
        $devices = $this->deviceRepo->getByLocationId($locationId, $limit, $offset);

        return $this->mapper->mapCollection($devices);
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
     * @return array<string, mixed>
     */
    public function create(?string $name,
                           ?string $netName,
                           ?string $ip,
                           ?int    $timeToCheck,
                           ?int    $locationId,
                           ?array  $outlets): array
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

        return $this->mapper->map($device);
    }
}