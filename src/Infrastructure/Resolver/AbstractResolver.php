<?php declare(strict_types = 1);

namespace App\Infrastructure\Resolver;

use App\Infrastructure\Excepiton\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractResolver implements ValueResolverInterface
{
    protected const CURRENT_CLASS = '';

    protected ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return static::CURRENT_CLASS === $argument->getType();
    }

    /**
     * @return iterable<RequestDtoInterface>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (static::CURRENT_CLASS === $argument->getType()) {
            $class = $argument->getType();
            /** @var RequestDtoInterface $dto */
            $dto = new $class($request);
            $this->validate($dto);
            yield $dto;
        }
    }

    private function validate(RequestDtoInterface $invoice): void
    {
        $violations = $this->validator->validate($invoice);
        if ($violations->count()) {
            $errors = [];

            /** @var ConstraintViolation $constraintViolation */
            foreach ($violations as $constraintViolation) {
                $errors[$constraintViolation->getPropertyPath()] = (string) $constraintViolation->getMessage();
            }

            throw new ValidationException($errors);
        }
    }
}