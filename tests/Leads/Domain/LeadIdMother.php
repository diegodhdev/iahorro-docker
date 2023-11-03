<?php

namespace Tests\Leads\Domain;

use Backend\Leads\Domain\LeadId;
use Tests\Shared\Domain\UuidMother;

final class LeadIdMother
{
    public static function create(?string $value = null): LeadId
    {
        return new LeadId($value ?? UuidMother::create());
    }
}
