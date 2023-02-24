<?php declare(strict_types = 1);

namespace App\Controller;

use App\Domain\Repository\DeviceRepository;
use App\Infrastructure\Mapper\DeviceMapper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/devices/{id}', name: 'deviceList', requirements: ['id' => '\d+'], methods: [Request::METHOD_GET])]
class DeviceListController
{
    public function __construct(
        private readonly DeviceRepository $deviceService,
        private readonly DeviceMapper $mapper
    ) {}

    public function __invoke(int $id): JsonResponse
    {
        $data = $this->deviceService->getById($id);
        if (null === $data) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse([
            'meta' => [
                'success' => true,
            ],
            'data' => $this->mapper->map($data),
        ]);
    }
}