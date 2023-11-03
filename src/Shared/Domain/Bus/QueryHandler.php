<?php

declare(strict_types=1);

namespace Backend\Shared\Domain\Bus;

use Backend\Shared\Infrastructure\Bus\QueryResponse;

interface QueryHandler
{
    public function handle(Query $query): QueryResponse;
}
