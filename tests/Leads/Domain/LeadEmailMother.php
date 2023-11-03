<?php

namespace Tests\Leads\Domain;

use Backend\Leads\Domain\LeadEmail;
use Tests\Shared\Domain\MotherCreator;

class LeadEmailMother
{
    public static function create(?string $value = null): LeadEmail
    {
        return new LeadEmail($value ?? MotherCreator::random()->email);
    }

}