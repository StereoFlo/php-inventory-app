<?php declare(strict_types = 1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Outlet;
use App\Domain\Repository\OutletReadRepository;
use App\Domain\Repository\OutletWriteRepository;
use Doctrine\ORM\EntityManagerInterface;

class OutletRepository implements OutletReadRepository, OutletWriteRepository
{
    public function __construct(private readonly EntityManagerInterface $manager) {}

    /**
     * @param int[] $ids
     * @return Outlet[]
     */
    public function getByIds(array $ids): array
    {
        $qb = $this->manager->createQueryBuilder();
        $qb->select('o')
            ->from(Outlet::class, 'o')
            ->where($qb->expr()->in('o.id', $ids));

        /** @var Outlet[]|null $res */
        $res = $qb->getQuery()->getResult();
        if (null === $res) {
            return [];
        }

        return $res;
    }

    public function getById(int $id): ?Outlet
    {
        /** @var Outlet|null $outlet */
        $outlet = $this->manager->find(Outlet::class, $id);

        return $outlet;
    }

    public function getByLocationId(int $id): ?array
    {
        /** @var Outlet[]|null $res */
        $res = $this->manager->createQueryBuilder()
            ->select('o')
            ->from(Outlet::class, 'o')
            ->where('o.locationId')
            ->getQuery()
            ->getResult();

        return $res;
    }

    public function save(Outlet $outlet): void
    {
        $this->manager->persist($outlet);
        $this->manager->flush();
    }
}