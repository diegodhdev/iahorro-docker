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

final class LeadMother
{

    public static function create(
        ?LeadId    $id = null,
        ?LeadName  $name = null,
        ?LeadEmail $email = null,
        ?LeadPhone $phone = null,
        ?LeadScore $score = null,
    ): Lead
    {
        return Lead::create(
            $id ?? LeadIdMother::create(),
            $name ?? LeadNameMother::create(),
            $email ?? LeadEmailMother::create(),
            $phone ?? LeadPhoneMother::create(),
            $score ?? null,
        );
    }

    public static function modify(
        ?LeadId    $id = null,
        ?LeadName  $name = null,
        ?LeadEmail $email = null,
        ?LeadPhone $phone = null,
        ?LeadScore $score = null,
    ): Lead
    {
        return Lead::modify(
            $id ?? LeadIdMother::create(),
            $name ?? LeadNameMother::create(),
            $email ?? LeadEmailMother::create(),
            $phone ?? LeadPhoneMother::create(),
            $score ?? LeadScoreMother::create(),
        );
    }

    public static function fromRequest(StoreLeadCommand $request): Lead
    {
        return self::create(
            LeadIdMother::create($request->id()),
            LeadNameMother::create($request->name()),
            LeadEmailMother::create($request->email()),
            LeadPhoneMother::create($request->phone())
        );
    }
}
