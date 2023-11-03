<?php

declare(strict_types=1);

namespace Backend\Leads\Domain;

interface LeadRepository
{
    public function save(Lead $lead): void;

    public function update(Lead $lead): void;

    public function findById(LeadId $id): ?Lead;

    public function delete(Lead $lead);
}
