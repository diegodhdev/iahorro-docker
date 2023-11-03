<?php

declare(strict_types=1);

namespace Backend\Leads\Domain;

use DomainException;

final class LeadNotFoundException extends DomainException
{
    public function __construct(string $id)
    {
        parent::__construct("Lead with id {$id} not found");
    }
}
