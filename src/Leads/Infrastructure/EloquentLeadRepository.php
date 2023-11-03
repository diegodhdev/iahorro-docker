<?php

declare(strict_types=1);

namespace Backend\Leads\Infrastructure;

use App\Models\Lead as EloquentLead;
use Backend\Leads\Domain\Lead;
use Backend\Leads\Domain\LeadEmail;
use Backend\Leads\Domain\LeadId;
use Backend\Leads\Domain\LeadName;
use Backend\Leads\Domain\LeadPhone;
use Backend\Leads\Domain\LeadRepository;
use Backend\Leads\Domain\LeadScore;

final class EloquentLeadRepository implements LeadRepository
{
    public function save(Lead $lead): void
    {
        $eloquentLead = new EloquentLead();

        $eloquentLead->id = $lead->id()->value();
        $eloquentLead->name = $lead->name()->value();
        $eloquentLead->email = $lead->email()->value();
        $eloquentLead->phone = $lead->phone()->value();

        $eloquentLead->save();
    }

    public function update(Lead $lead): void
    {
        $eloquentLead = EloquentLead::where('id', $lead->id()->value())->first();

        $eloquentLead->name = $lead->name()->value();
        $eloquentLead->email = $lead->email()->value();
        $eloquentLead->phone = $lead->phone()?->value();
        $eloquentLead->score = $lead->score()?->value();
        $eloquentLead->save();
    }

    public function findById(LeadId $id): ?Lead
    {
        $eloquentLead = EloquentLead::where('id', $id->value())->first();

        if (!$eloquentLead) {
            return null;
        }

        return Lead::create(
            new LeadId($eloquentLead->id),
            new LeadName($eloquentLead->name),
            new LeadEmail($eloquentLead->email),
            new LeadPhone($eloquentLead->phone),
            new LeadScore($eloquentLead->score)
        );
    }

    public function delete(Lead $lead): void
    {
        $eloquentLead = EloquentLead::where('id', $lead->id()->value())->first();

        $eloquentLead->delete();
    }
}
