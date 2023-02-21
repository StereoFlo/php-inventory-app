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
        $this->name        = $request->request->has('name') ? (string) $request->request->get('name') : null;
        $this->netName     = $request->request->has('net_name') ? (string) $request->request->get('net_name') : null;
        $this->ip          = $request->request->has('name') ? (string) $request->request->get('name') : null;
        $this->timeToCheck = $request->request->has('time_to_check') ? (int) $request->request->get('time_to_check') : null;
        $this->locationId  = $request->request->has('location_id') ? (int) $request->request->get('location_id') : null;
        $this->outlets     = $request->request->has('outlets') ? (array) $request->request->get('outlets') : null;
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