<?php declare(strict_types = 1);

namespace App\Domain\Entity;

use DateTimeImmutable;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity]
#[ORM\Table(name: 'devices')]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(type: 'string', length: 250, options: ['default' => null])]
    private readonly ?string $name;

    #[ORM\Column(type: 'string', length: 250, options: ['default' => null])]
    private readonly ?string $netName;

    #[ORM\Column(type: 'string', length: 15, options: ['default' => null])]
    private readonly ?string $ip;

    #[ORM\Column(type: 'integer', length: 1, options: ['default' => null])]
    private readonly ?int $timeToCheck;

    #[ORM\Column(type: 'integer', options: ['default' => null, 'unsigned' => true])]
    private readonly ?int $locationId;

    /**
     * @var Outlet[]|null
     */
    #[ORM\ManyToMany(targetEntity: Outlet::class, inversedBy: 'devices')]
    #[ORM\JoinTable(name: 'devices_outlets')]
    private readonly ?array $outlets;

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
        ?array $outlets
    )
    {
        $this->id        = -1;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();

        $this->name        = $name;
        $this->netName     = $netName;
        $this->ip          = $ip;
        $this->timeToCheck = $timeToCheck;
        $this->locationId   = $locationId;
        $this->outlets      = $outlets;
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
     * @return Outlet[]
     */
    public function getOutlets(): ?array
    {
        return $this->outlets;
    }
}