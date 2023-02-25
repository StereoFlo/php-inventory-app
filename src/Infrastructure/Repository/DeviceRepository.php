<?php declare(strict_types = 1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Device;
use App\Domain\Repository\DeviceRepository as DeviceRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DeviceRepository implements DeviceRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $manager) {}

    public function getByLocationId(int $locationId, int $limit, int $offset): ?Device
    {
        /** @var Device|null $device */
        $device = $this->manager->createQueryBuilder()
            ->select('device')
            ->from(Device::class, 'device')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getOneOrNullResult();

        return $device;
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