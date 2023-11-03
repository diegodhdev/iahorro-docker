<?php

declare(strict_types=1);

namespace Backend\Leads\Application\Update;

use Backend\Leads\Domain\Lead;
use Backend\Leads\Domain\LeadEmail;
use Backend\Leads\Domain\LeadId;
use Backend\Leads\Domain\LeadName;
use Backend\Leads\Domain\LeadNotFoundException;
use Backend\Leads\Domain\LeadPhone;
use Backend\Leads\Domain\LeadRepository;

final class LeadUpdater
{
    public function __construct(private readonly LeadRepository $leadRepository) {}

    public function __invoke(LeadId $id, LeadName $name, LeadEmail $email, LeadPhone $phone)
    {
        $lead = $this->leadRepository->findById($id);

        if($lead === null) {
            throw new LeadNotFoundException($id->value());
        }

        $lead = Lead::modify($lead->id(), $name, $email, $phone, null);
        $this->leadRepository->update($lead);
    }
}
