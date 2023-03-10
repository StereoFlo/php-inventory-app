<?php declare(strict_types = 1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Device;
use App\Domain\Repository\DeviceReadRepository;
use App\Domain\Repository\DeviceWriteRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeviceRepository implements DeviceReadRepository, DeviceWriteRepository
{
    public function __construct(private readonly EntityManagerInterface $manager) {}

    /**
     * @return Device[]
     */
    public function getByLocationId(int $locationId, int $limit, int $offset): array
    {
        /** @var Device[]|null $devices */
        $devices = $this->manager->createQueryBuilder()
            ->select('device')
            ->from(Device::class, 'device')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();

        if (null === $devices) {
            return [];
        }

        return $devices;
    }

    public function getById(int $id): ?Device
    {
        $qb = $this->manager->createQueryBuilder();
        $qb->select('device')
            ->from(Device::class, 'device')
            ->where($qb->expr()->eq('device.id', '?1'))
            ->setParameter(1, $id);;
        /** @var Device|null $device */
        $device = $qb
            ->getQuery()
            ->getOneOrNullResult();

        return $device;
    }

    /**
     * @param int[] $ids
     * @return Device[]|null
     */
    public function getByIds(array $ids): ?array
    {
        $qb = $this->manager->createQueryBuilder();
        $qb->select('device')
            ->from(Device::class, 'device')
            ->where($qb->expr()->in('device.id', $ids));
        /** @var Device[]|null $device */
        $device = $qb
            ->getQuery()
            ->getResult();

        return $device;
    }

    public function getByNameAndIp(string $name, string $ip): ?Device
    {
        /** @var Device|null $device */
        $device = $this->manager->createQueryBuilder()
            ->select('device')
            ->from(Device::class, 'device')
            ->where('device.name like ?', '%' . $name . '%')
            ->andWhere('device.ip = ?', $ip)
            ->getQuery()
            ->getOneOrNullResult();

        return $device;
    }

    public function save(Device $device): void
    {
        $this->manager->persist($device);
        $this->manager->flush();
    }
}