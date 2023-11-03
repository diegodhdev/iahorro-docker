<?php

declare(strict_types=1);

namespace Backend\Shared\Domain\Bus;

interface EventBus
{
    public function publish(DomainEvent ...$events): void;
}
