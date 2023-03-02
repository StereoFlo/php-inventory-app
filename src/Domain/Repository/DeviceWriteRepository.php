<?php declare(strict_types = 1);

namespace App\Domain\Repository;

use App\Domain\Entity\Device;

interface DeviceWriteRepository
{
    public function save(Device $device): void;
}