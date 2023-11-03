<?php

declare(strict_types=1);

namespace Backend\Shared\Domain;

use DomainException;

final class HasNotValidSizeException extends DomainException
{
    public function __construct($minLength, $maxLength)
    {
        parent::__construct(sprintf('Lead name must be between %s and %s characters', $minLength, $maxLength));
    }
}
