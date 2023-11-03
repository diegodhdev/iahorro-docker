<?php

declare(strict_types=1);

namespace Tests\Leads\Domain;

use Backend\Leads\Application\Store\StoreLeadCommand;
use Backend\Leads\Domain\Lead;
use Backend\Leads\Domain\LeadEmail;
use Backend\Leads\Domain\LeadId;
use Backend\Leads\Domain\LeadName;
use Backend\Leads\Domain\LeadPhone;
use Backend\Leads\Domain\LeadScore;

final class StoreLeadCommandMother
{

    public static function create(
        ?string    $id = null,
        ?string  $name = null,
        ?string $email = null,
        ?string $phone = null,
    ): StoreLeadCommand
    {
        return new StoreLeadCommand(
            $id ?? LeadIdMother::create()->value(),
            $name ?? LeadNameMother::create()->value(),
            $email ?? LeadEmailMother::create()->value(),
            $phone ?? LeadPhoneMother::create()->value(),
        );
    }

}
