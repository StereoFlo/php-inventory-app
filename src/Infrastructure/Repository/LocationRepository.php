<?php declare(strict_types = 1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Location;
use App\Domain\Repository\LocationRepository as LocationRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class LocationRepository implements LocationRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $manager) {}

    /**
     * @return Location[]|null
     */
    public function getFirstLevel(): ?array
    {
        $qb = $this->manager->createQueryBuilder();
        $qb->select('l');
        $qb->from(Location::class, 'l');
        $qb->where($qb->expr()->isNotNull('l.locationId'));
        /** @var Location[]|null $res */
        $res = $qb->getQuery()->getResult();

        return $res;
    }

    public function getById(int $id): ?Location
    {
        return $this->manager->find(Location::class, $id);
    }

    /**
     * @param int[] $ids
     * @return Location[]|null
     */
    public function getByIds(array $ids): ?array
    {
        $qb = $this->manager->createQueryBuilder();
        $qb->select('l');
        $qb->from(Location::class, 'l');
        $qb->where($qb->expr()->in('l.id', $ids));
        /** @var Location[]|null $res */
        $res = $qb->getQuery()->getResult();

        return $res;
    }

    public function save(Location $location): void
    {
        $this->manager->persist($location);
        $this->manager->flush();
    }
}