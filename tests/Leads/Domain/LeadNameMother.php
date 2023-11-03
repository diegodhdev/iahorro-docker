<?php

namespace Tests\Leads\Domain;

use Backend\Leads\Domain\LeadName;
use Tests\Shared\Domain\MotherCreator;


class LeadNameMother
{
    public static function create(?string $value = null): LeadName
    {
        return new LeadName(value: $value ?? MotherCreator::random()->name);
    }
}