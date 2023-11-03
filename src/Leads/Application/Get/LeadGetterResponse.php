<?php

declare(strict_types=1);

namespace Backend\Leads\Application\Get;

use Backend\Shared\Infrastructure\Bus\QueryResponse;

final class LeadGetterResponse implements QueryResponse
{
    public function __construct(private readonly array $lead) {}

    public function lead(): array
    {
        return $this->lead;
    }
}
