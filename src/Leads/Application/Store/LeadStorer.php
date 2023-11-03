<?php

declare(strict_types=1);

namespace Backend\Leads\Application\Store;

use Backend\Leads\Domain\Lead;
use Backend\Leads\Domain\LeadEmail;
use Backend\Leads\Domain\LeadId;
use Backend\Leads\Domain\LeadName;
use Backend\Leads\Domain\LeadPhone;
use Backend\Leads\Domain\LeadRepository;
use Backend\Leads\Domain\LeadScore;
use Backend\Leads\Domain\LeadScoringService;
use Backend\Shared\Domain\Bus\EventBus;

final class LeadStorer
{
    public function __construct(private readonly LeadRepository $leadRepository, private readonly EventBus $eventBus, private readonly LeadScoringService $leadScoringService) {}

    public function __invoke(LeadId $id, LeadName $name, LeadEmail $email, LeadPhone $phone)
    {
        // Create lead
        $lead = Lead::create($id, $name, $email, $phone);
        $this->leadRepository->save($lead);

        // Calling leadScoringService
        $score = $this->leadScoringService->getLeadScore($lead);

        // Update score for previously created lead
        $leadUpdate = Lead::modify($lead->id(), $lead->name(), $lead->email(), $lead->phone(), new LeadScore($score));
        $this->leadRepository->update($leadUpdate);

        $this->eventBus->publish(...$lead->pullDomainEvents());
    }
}
