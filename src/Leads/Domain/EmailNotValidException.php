<?php

declare(strict_types=1);

namespace Backend\Leads\Domain;

use DomainException;

final class EmailNotValidException extends DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
