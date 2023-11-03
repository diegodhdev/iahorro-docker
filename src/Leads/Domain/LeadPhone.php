<?php

declare(strict_types=1);

namespace Backend\Leads\Domain;

use Backend\Shared\Domain\HasNotValidSizeException;

final class LeadPhone
{
    final public const MIN_LENGTH = 9;
    final public const MAX_LENGTH = 20;

    public function __construct(protected ?string $value)
    {
        if ($this->value !== null) {
            $this->ensureHasAValidSize($value);
        }
    }

    public function value(): ?string
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
