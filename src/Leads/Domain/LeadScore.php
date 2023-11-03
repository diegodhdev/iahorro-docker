<?php

declare(strict_types=1);

namespace Backend\Leads\Domain;

final class LeadScore
{
    public function __construct(protected ?float $value) {}

    public function value(): ?float
    {
        return $this->value;
    }
}
