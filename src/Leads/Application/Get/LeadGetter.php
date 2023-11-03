<?php

declare(strict_types=1);

namespace Backend\Leads\Application\Get;

use Backend\Leads\Domain\LeadId;
use Backend\Leads\Domain\LeadNotFoundException;
use Backend\Leads\Domain\LeadRepository;

final class LeadGetter
{
    public function __construct(private readonly LeadRepository $repository) {}

    public function __invoke(LeadId $leadId): ?LeadGetterResponse
    {
        $lead = $this->repository->findById($leadId);

        if ($lead === null) {
            throw new LeadNotFoundException($leadId->value());
        }

        return new LeadGetterResponse($lead->toArray());
    }
}
