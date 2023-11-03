<?php

namespace Tests\Clients\Domain;

use Backend\Clients\Domain\ClientLeadId;
use Tests\Shared\Domain\UuidMother;

class ClientLeadIdMother
{
    public static function create(?string $value = null): ClientLeadId
    {
        return new ClientLeadId($value ?? UuidMother::create());
    }
}