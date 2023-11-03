<?php

declare(strict_types=1);

namespace Backend\Leads\Domain;

use Backend\Shared\Domain\Bus\DomainEvent;

final class LeadStoredDomainEvent extends DomainEvent
{
    public function __construct(
        string $id,
        private readonly string $email,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'lead.stored';
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, $body['email'], $eventId, $occurredOn);
    }

    public function toPrimitives(): array
    {
        return [
            'email' => $this->email,
        ];
    }

    public function email(): string
    {
        return $this->email;
    }
}
