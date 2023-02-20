<?php declare(strict_types = 1);

namespace App\Infrastructure\Excepiton;

use InvalidArgumentException;
use Throwable;
use function implode;

class ValidationException extends InvalidArgumentException
{
    /**
     * @var array<string, string>
     */
    private array $errors;

    /**
     * @param array<string, string> $errors errors from constraints
     */
    public function __construct(array $errors, string $message = '', int $code = 0, Throwable $previous = null)
    {
        $message = implode(\PHP_EOL, $errors);
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * @return array<string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}