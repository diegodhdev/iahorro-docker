<?php

declare(strict_types=1);

namespace Backend\Clients\Domain;

use DomainException;

final class EmailDuplicatedException extends DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
