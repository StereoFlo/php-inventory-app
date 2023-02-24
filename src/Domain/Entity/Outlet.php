<?php declare(strict_types = 1);

namespace App\Domain\Entity;

use DateTimeImmutable;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'outlets')]
class Outlet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(type: 'string', length: 250)]
    private string $name;

    #[ORM\Column(type: 'integer', options: ['default' => null, 'unsigned' => true])]
    #[ORM\ManyToOne(targetEntity: Location::class)]
    #[ORM\JoinColumn(name: 'location_id', referencedColumnName: 'id')]
    private ?int $locationId;

    /**
     * @var Collection<Device>
     */
    #[ORM\ManyToMany(targetEntity: Device::class, inversedBy: 'outlets')]
    private Collection $devices;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    /**
     * @param Device[] $devices
     */
    public function __construct(
        string $name,
        ?int $locationId,
        array $devices = [],
    )
    {
        $this->id        = -1;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();

        $this->name       = $name;
        $this->locationId = $locationId;
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

    public function getLocationId(): ?int
    {
        return $this->locationId;
    }

    /**
     * @return Collection<Device>
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }
}