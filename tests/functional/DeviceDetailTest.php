<?php

namespace App\Tests\functional;

use App\Controller\DeviceDetailController;
use App\Domain\Entity\Device;
use App\Domain\Service\DeviceService;
use App\Infrastructure\Mapper\DeviceMapper;
use App\Infrastructure\Mapper\OutletMapper;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DeviceDetailTest extends KernelTestCase
{
    public function testGetById(): void
    {
        $device     = $this->getDevice();
        $deviceRepo = $this->getDeviceRepository($device);

        $controller = new DeviceDetailController($deviceRepo, new DeviceMapper(new OutletMapper()));
        $response   = $controller(1);
        $content    = $response->getContent();
        $arr        = json_decode($content, true);
        $this->assertEquals($arr['data']['id'], $device->getId());
        $this->assertEquals($arr['data']['outlets'], null);
    }

    public function getDevice(): Device
    {
        $device = $this->createMock(Device::class);
        $device->method('getId')
            ->willReturn(1);
        $device->method('getName')
            ->willReturn('name');
        $device->method('getNetName')
            ->willReturn('net ame');
        $device->method('getIp')
            ->willReturn('127.0.0.1');
        $device->method('getTimeToCheck')
            ->willReturn(null);
        $device->method('getLocationId')
            ->willReturn(null);
        $device->method('getOutlets')
            ->willReturn(new ArrayCollection());
        $device->method('getCreatedAt')
            ->willReturn(new DateTimeImmutable());
        $device->method('getUpdatedAt')
            ->willReturn(new DateTimeImmutable());

        return $device;
    }

    private function getDeviceRepository(Device $device): DeviceService
    {
        $deviceRepo = $this->createMock(DeviceService::class);
        $deviceRepo->expects($this->once())
            ->method('getById')
            ->willReturn($device);
        return $deviceRepo;
    }
}