<?php

namespace Tests\Leads\Domain;

use Backend\Leads\Domain\LeadScore;
use Tests\Shared\Domain\MotherCreator;

class LeadScoreMother
{
    public static function create(?string $value = null): LeadScore
    {
        return new LeadScore($value ?? MotherCreator::random()->randomFloat(1, 10));
    }
}