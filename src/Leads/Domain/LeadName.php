<?php

declare(strict_types=1);

namespace Backend\Leads\Domain;

use Backend\Shared\Domain\HasNotValidSizeException;

final class LeadName
{
    final public const MIN_LENGTH = 1;
    final public const MAX_LENGTH = 255;

    public function __construct(protected string $value)
    {
        $this->ensureHasAValidSize($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    private function ensureHasAValidSize(string $value): void
    {
        if (strlen($value) < self::MIN_LENGTH || strlen($value) > self::MAX_LENGTH) {
            throw new HasNotValidSizeException(self::MIN_LENGTH, self::MAX_LENGTH);
        }
    }
}
