<?php

namespace Tests\Clients\Domain;

use Backend\Clients\Domain\ClientId;
use Tests\Shared\Domain\UuidMother;

class ClientIdMother
{
    public static function create(?string $value = null): ClientId
    {
        return new ClientId($value ?? UuidMother::create());
    }
}