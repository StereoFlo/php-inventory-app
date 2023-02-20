<?php declare(strict_types = 1);

namespace App\Infrastructure\Dto;

use App\Infrastructure\Resolver\RequestDtoInterface;
use Symfony\Component\HttpFoundation\Request;

class DeviceCreateDto implements RequestDtoInterface
{
    private readonly ?string $name;
    private readonly ?string $netName;
    private readonly ?string $ip;
    private readonly ?int $timeToCheck;
    private readonly ?int $locationId;

    /**
     * @var array<int>|null
     */
    private readonly ?array $outlets;

    public function __construct(Request $request)
    {
        $this->name        = $request->request->get('name');
        $this->netName     = $request->request->get('net_name');
        $this->ip          = $request->request->get('ip');
        $this->timeToCheck = $request->request->get('time_to_check');
        $this->locationId  = $request->request->get('location_id');
        $this->outlets     = $request->request->get('outlets');
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
     * @return int[]|null
     */
    public function getOutlets(): ?array
    {
        return $this->outlets;
    }
}