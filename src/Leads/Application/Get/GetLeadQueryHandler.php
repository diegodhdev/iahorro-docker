<?php

declare(strict_types=1);

namespace Backend\Leads\Application\Get;

use Backend\Leads\Domain\LeadId;
use Backend\Shared\Domain\Bus\QueryHandler;
use Backend\Shared\Infrastructure\Bus\QueryResponse;

final class GetLeadQueryHandler implements QueryHandler
{
    public function __construct(private readonly LeadGetter $getter) {}

    public function handle($query): QueryResponse
    {
        return $this->getter->__invoke(new LeadId($query->id()));
    }
}
