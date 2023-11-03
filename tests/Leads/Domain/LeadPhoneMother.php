<?php

namespace Tests\Leads\Domain;

use Backend\Leads\Domain\LeadPhone;
use Tests\Shared\Domain\MotherCreator;


class LeadPhoneMother
{
    public static function create(?string $value = null): LeadPhone
    {
        return new LeadPhone($value ?? MotherCreator::random()->numberBetween(666_666_666, 699_999_999));
    }
}