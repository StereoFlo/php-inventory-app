<?php declare(strict_types = 1);

namespace App\Infrastructure\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Responder
{
    public function success(mixed $data): Response
    {
        return new JsonResponse([
            'meta' => ['success' => true],
            'data' => $data,
        ]);
    }

    public function successList(mixed $data, int $total, int $limit, int $offset): Response
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

    public function fail(mixed $data, int $code = 500): Response
    {
        return new JsonResponse([
            'meta' => ['success' => true],
            'data' => $data,
        ], $code);
    }
}