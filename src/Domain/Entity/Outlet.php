<?php declare(strict_types = 1);

namespace App\Domain\Entity;

use DateTimeImmutable;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'outlets')]
class Outlet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    /**
     * @param Device[]|null $devices
     */
    public function __construct(
        private readonly string $name,
        private readonly ?int $locationId,
        private readonly ?array $devices,
    )
    {
        $this->id        = -1;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
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
     * @return Device[]|null
     */
    public function getDevices(): ?array
    {
        return $this->devices;
    }
}