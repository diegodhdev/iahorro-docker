<?php

declare(strict_types=1);

namespace Backend\Leads\Application\Get;

use Backend\Shared\Domain\Bus\Query;

final class GetLeadQuery implements Query
{
    public function __construct(private readonly string $id) {}

    public function id(): string
    {
        return $this->id;
    }
}
