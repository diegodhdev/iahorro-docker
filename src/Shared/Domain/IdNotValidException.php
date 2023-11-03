<?php

declare(strict_types=1);

namespace Backend\Shared\Domain;

use DomainException;

final class IdNotValidException extends DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
