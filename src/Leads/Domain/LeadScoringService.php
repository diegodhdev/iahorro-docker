<?php

declare(strict_types=1);

namespace Backend\Leads\Domain;

interface LeadScoringService
{
    public function getLeadScore(Lead $lead): float;
}
