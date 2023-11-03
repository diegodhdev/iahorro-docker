<?php

declare(strict_types=1);

namespace Backend\Shared\Domain\Bus;

interface DomainEventSubscriber
{
    public static function subscribedTo(): array;
}
