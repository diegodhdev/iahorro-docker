<?php

declare(strict_types=1);

namespace Backend\Leads\Domain;

use Backend\Shared\Domain\IdNotValidException;
use Ramsey\Uuid\Rfc4122\Validator;

final class LeadId
{
    public function __construct(protected string $value)
    {
        $this->ensureIsAValidId($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    private function ensureIsAValidId(string $id): void
    {
        if (!(new Validator())->validate($id)) {
            throw new IdNotValidException(sprintf('Id "%s"  not valid.', $id));
        }
    }
}
