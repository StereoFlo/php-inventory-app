<?php declare(strict_types = 1);

use App\Infrastructure\Dto\DeviceCreateDto;
use App\Infrastructure\Resolver\AbstractResolver;

class DeviceCreateResolver extends AbstractResolver {
    protected const CURRENT_CLASS = DeviceCreateDto::class;
}