<?php

declare(strict_types=1);

namespace Backend\Leads\Application\Destroy;

use Backend\Leads\Domain\LeadId;
use Backend\Leads\Domain\LeadNotFoundException;
use Backend\Leads\Domain\LeadRepository;

final class LeadDestroyer
{
    public function __construct(private readonly LeadRepository $leadRepository) {}

    public function __invoke(LeadId $id)
    {
        $lead = $this->leadRepository->findById($id);

        if($lead === null) {
            throw new LeadNotFoundException($id->value());
        }

        $this->leadRepository->delete($lead);
    }
}
