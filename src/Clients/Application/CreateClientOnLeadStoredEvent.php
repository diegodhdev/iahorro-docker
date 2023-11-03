<?php

declare(strict_types=1);

namespace Backend\Clients\Application;

use Backend\Leads\Domain\LeadStoredDomainEvent;
use Backend\Shared\Domain\Bus\DomainEventSubscriber;

final class CreateClientOnLeadStoredEvent implements DomainEventSubscriber
{
    public function __construct(private readonly ClientCreator $creator) {}

    public static function subscribedTo(): array
    {
        return [LeadStoredDomainEvent::class];
    }

    public function __invoke(LeadStoredDomainEvent $event): void
    {
        $this->creator->__invoke($event->email(), $event->aggregateId());
    }
}
