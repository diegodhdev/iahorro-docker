<?php

declare(strict_types=1);

namespace Backend\Clients\Domain;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

final class ClientEmail
{
    public function __construct(protected string $value)
    {
        $this->ensureIsValidEmail($value);
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
}
