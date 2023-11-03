<?php

declare(strict_types=1);

namespace Backend\Clients\Domain;

final class Client
{
    public function __construct(private readonly ClientEmail $email, private readonly ClientLeadId $leadId) {}


    public function email(): ClientEmail
    {
        return $this->email;
    }

    public function leadId(): ClientLeadId
    {
        return $this->leadId;
    }

    public static function create(ClientEmail $email, ClientLeadId $leadId): self
    {
        return new self($email, $leadId);
    }

    public static function modify(ClientEmail $email, ClientLeadId $leadId): self
    {
        return new self($email, $leadId);
    }
}
