<?php declare(strict_types = 1);

namespace App\Domain\Entity;

use DateTimeImmutable;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'locations')]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(type: 'string', length: 250)]
    private string $name;

    #[ORM\Column(type: 'string', length: 50)]
    private string $type;

    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[ORM\ManyToOne(targetEntity: Location::class)]
    #[ORM\JoinColumn(name: 'location_id', referencedColumnName: 'id')]
    private ?int $locationId;

    /**
     * @var Collection<self>
     */
    #[ORM\OneToMany(mappedBy: 'locationId', targetEntity: self::class)]
    private Collection $children;

    /**
     * @var Collection<Outlet>
     */
    #[ORM\OneToMany(mappedBy: 'locationId', targetEntity: Outlet::class)]
    private Collection $outlets;

    /**
     * @var Collection<Device>
     */
    #[ORM\OneToMany(mappedBy: 'locationId', targetEntity: Device::class)]
    private Collection $devices;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    /**
     * @param self[] $children
     * @param Outlet[] $outlets
     * @param Device[] $devices
     */
    public function __construct(
        string $name,
        string $type,
        ?int $locationId,
        array $children = [],
        array $outlets = [],
        array $devices = [],
    )
    {
        $this->id        = -1;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();

        $this->name       = $name;
        $this->type       = $type;
        $this->locationId = $locationId;
        $this->children   = new ArrayCollection($children);
        $this->outlets    = new ArrayCollection($outlets);
        $this->devices    = new ArrayCollection($devices);
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getLocationId(): ?int
    {
        return $this->locationId;
    }

    /**
     * @return Collection<Location>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /**
     * @return Collection<Outlet>
     */
    public function getOutlets(): Collection
    {
        return $this->outlets;
    }

    /**
     * @return Collection<Device>
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }
}