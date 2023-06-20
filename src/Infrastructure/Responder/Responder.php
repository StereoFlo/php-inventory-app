<?php declare(strict_types = 1);

namespace App\Infrastructure\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;

class Responder
{
    public function success(mixed $data): JsonResponse
    {
        return new JsonResponse([
            'meta' => ['success' => true],
            'data' => $data,
        ]);
    }

    public function successList(mixed $data, int $total, int $limit, int $offset): JsonResponse
    {
        return new JsonResponse([
            'meta' => [
                'success' => true,
                'limit'   => $limit,
                'total'   => $total,
                'offset'  => $offset,
            ],
            'data' => $data
        ]);
    }

    public function fail(mixed $data, int $code = 500): JsonResponse
    {
        return new JsonResponse([
            'meta' => ['success' => true],
            'data' => $data,
        ], $code);
    }
}