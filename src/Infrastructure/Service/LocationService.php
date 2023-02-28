<?php declare(strict_types = 1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Device;
use App\Domain\Entity\Location;
use App\Domain\Entity\Outlet;
use App\Domain\Repository\DeviceRepository;
use App\Domain\Repository\LocationRepository;
use App\Domain\Repository\OutletRepository;
use App\Domain\Service\LocationService as LocationServiceInterface;
use App\Infrastructure\Mapper\LocationMapper;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function count;

class LocationService implements LocationServiceInterface
{
    public function __construct(
        private readonly LocationRepository $locationRepo,
        private readonly OutletRepository $outletRepo,
        private readonly DeviceRepository $deviceRepo,
        private readonly LocationMapper $mapper,
    ) {}

    /**
     * @return array<array<string, mixed>>
     */
    public function getFirstLevel(): array
    {
        $res = $this->locationRepo->getFirstLevel();
        if (empty($res)) {
            return [];
        }

        return $this->mapper->mapCollection($res);
    }

    /**
     * @return array<string, mixed>
     */
    public function getById(int $id): array
    {
        $location = $this->locationRepo->getById($id);
        if (null === $location) {
            throw new NotFoundHttpException();
        }

        return $this->mapper->map($location);
    }

    /**
     * @param int[] $ids
     * @return array<array<string, mixed>>
     */
    public function getByIds(array $ids): array
    {
        $res = $this->locationRepo->getByIds($ids);
        if (empty($res)) {
            return [];
        }

        return $this->mapper->mapCollection($res);
    }

    /**
     * @param int[] $childrenIds
     * @param int[] $deviceIds
     * @param int[] $outletsIds
     */
    public function create(string $name, string $type, ?int $locationId, array $childrenIds = [], array $deviceIds = [], array $outletsIds = []): void
    {
        /** @var Location[] $children */
        $children = [];
        /** @var Device[] $devices */
        $devices = [];
        /** @var Outlet[] $outlets */
        $outlets = [];
        if (0 < count($childrenIds)) {
            $children = $this->locationRepo->getByIds($childrenIds);
        }
        if (0 < count($deviceIds)) {
            $devices = $this->deviceRepo->getByIds($deviceIds);
        }
        if (0 < count($outletsIds)) {
            $outlets = $this->outletRepo->getByIds($outletsIds);
        }

        $location = new Location($name, $type, $locationId, $children, $outlets, $devices);
        $this->locationRepo->save($location);
    }
}