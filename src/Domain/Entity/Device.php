<?php declare(strict_types = 1);

namespace App\Domain\Entity;

use DateTimeImmutable;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'devices')]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(type: 'string', length: 250, options: ['default' => null])]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 250, options: ['default' => null])]
    private ?string $netName;

    #[ORM\Column(type: 'string', length: 15, options: ['default' => null])]
    private ?string $ip;

    #[ORM\Column(type: 'integer', length: 1, options: ['default' => null])]
    private ?int $timeToCheck;

    #[ORM\Column(type: 'integer', options: ['default' => null, 'unsigned' => true])]
    #[ORM\ManyToOne(targetEntity: Location::class)]
    #[ORM\JoinColumn(name: 'location_id', referencedColumnName: 'id')]
    private ?int $locationId;

    /**
     * @var Collection<Outlet>
     */
    #[ORM\ManyToMany(targetEntity: Outlet::class, inversedBy: 'devices')]
    #[ORM\JoinTable(name: 'devices_outlets')]
    private Collection $outlets;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    /**
     * @param Outlet[] $outlets
     */
    public function __construct(
        ?string $name,
        ?string $netName,
        ?string $ip,
        ?int $timeToCheck,
        ?int $locationId,
        array $outlets = []
    )
    {
        $this->id        = -1;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();

        $this->name        = $name;
        $this->netName     = $netName;
        $this->ip          = $ip;
        $this->timeToCheck = $timeToCheck;
        $this->locationId  = $locationId;
        $this->outlets     = new ArrayCollection($outlets);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getNetName(): ?string
    {
        return $this->netName;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function getTimeToCheck(): ?int
    {
        return $this->timeToCheck;
    }

    public function getLocationId(): ?int
    {
        return $this->locationId;
    }

    /**
     * @return Collection<Outlet>
     */
    public function getOutlets(): Collection
    {
        return $this->outlets;
    }
}