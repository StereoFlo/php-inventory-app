<?php declare(strict_types = 1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Device;
use App\Domain\Entity\Location;
use App\Domain\Entity\Outlet;
use App\Domain\Repository\DeviceReadRepository;
use App\Domain\Repository\LocationReadRepository;
use App\Domain\Repository\OutletReadRepository;
use App\Domain\Service\LocationService as LocationServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function count;

class LocationService implements LocationServiceInterface
{
    public function __construct(
        private readonly LocationReadRepository $locationRepo,
        private readonly OutletReadRepository   $outletRepo,
        private readonly DeviceReadRepository   $deviceRepo
    ) {}

    /**
     * @return Location[]
     */
    public function getFirstLevel(): array
    {
        $res = $this->locationRepo->getFirstLevel();
        if (empty($res)) {
            return [];
        }

        return $res;
    }

    public function getById(int $id): Location
    {
        $location = $this->locationRepo->getById($id);
        if (null === $location) {
            throw new NotFoundHttpException();
        }

        return $location;
    }

    /**
     * @param int[] $ids
     * @return Location[]
     */
    public function getByIds(array $ids): array
    {
        $res = $this->locationRepo->getByIds($ids);
        if (empty($res)) {
            return [];
        }

        return $res;
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

        $location = new Location($name, $type, $locationId, $children ?? [], $outlets ?? [], $devices ?? []);
        $this->locationRepo->save($location);
    }
}