<?php

declare(strict_types=1);

namespace Backend\Clients\Domain;

final class ClientLeadId
{
    public function __construct(protected string $value) {}

    public function value(): string
    {
        return $this->value;
    }
}
