<?php

declare(strict_types=1);

namespace Backend\Leads\Domain;

use Backend\Shared\Infrastructure\Bus\AggregateRoot;

final class Lead extends AggregateRoot
{
    public function __construct(private readonly LeadId $id, private readonly LeadName $name, private readonly LeadEmail $email, private readonly ?LeadPhone $phone = null, private readonly ?LeadScore $score = null) {}

    public static function create(
        LeadId $id,
        LeadName $name,
        LeadEmail $email,
        ?LeadPhone $phone = null,
        ?LeadScore $score = null
    ): self {
        $lead = new self($id, $name, $email, $phone, $score);

        $lead->record(new LeadStoredDomainEvent($id->value(), $email->value()));

        return $lead;
    }

    public static function modify(
        LeadId $id,
        LeadName $name,
        LeadEmail $email,
        ?LeadPhone $phone,
        ?LeadScore $score
    ): self {
        return new self($id, $name, $email, $phone, $score);
    }

    public function id(): LeadId
    {
        return $this->id;
    }

    public function name(): LeadName
    {
        return $this->name;
    }

    public function email(): LeadEmail
    {
        return $this->email;
    }

    public function phone(): ?LeadPhone
    {
        return $this->phone;
    }

    public function score(): ?LeadScore
    {
        return $this->score;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'name' => $this->name()->value(),
            'email' => $this->email()->value(),
            'phone' => $this->phone()?->value(),
            'score' => $this->score()?->value(),
        ];
    }
}
