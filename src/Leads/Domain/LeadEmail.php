<?php

declare(strict_types=1);

namespace Backend\Leads\Domain;

use Backend\Shared\Domain\HasNotValidSizeException;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

final class LeadEmail
{
    final public const MIN_LENGTH = 1;
    final public const MAX_LENGTH = 255;

    public function __construct(protected string $value)
    {
        $this->ensureIsValidEmail($value);
        $this->ensureHasAValidSize($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    private function ensureIsValidEmail(string $email): void
    {
        $validator = new EmailValidator();

        if (!$validator->isValid($email, new RFCValidation())) {
            throw new EmailNotValidException(sprintf('Email "%s"  not valid.', $email));
        }
    }

    private function ensureHasAValidSize(string $value): void
    {
        if (strlen($value) < self::MIN_LENGTH || strlen($value) > self::MAX_LENGTH) {
            throw new HasNotValidSizeException(self::MIN_LENGTH, self::MAX_LENGTH);
        }
    }
}
