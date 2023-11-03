<?php

namespace Tests\Clients\Domain;

use Backend\Clients\Domain\ClientEmail;
use Tests\Shared\Domain\MotherCreator;

class ClientEmailMother
{
    public static function create(?string $value = null): ClientEmail
    {
        return new ClientEmail($value ?? MotherCreator::random()->email);
    }
}