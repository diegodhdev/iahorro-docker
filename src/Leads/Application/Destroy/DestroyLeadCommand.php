<?php

declare(strict_types=1);

namespace Backend\Leads\Application\Destroy;

use Backend\Shared\Domain\Bus\Command;

final class DestroyLeadCommand implements Command
{
    public function __construct(private readonly string $id) {}

    public function id(): string
    {
        return $this->id;
    }
}
