<?php

declare(strict_types=1);

namespace Backend\Clients\Domain;

interface ClientRepository
{
    public function save(Client $client): void;

    public function update(Client $client): void;

    public function findByEmail(ClientEmail $id): ?Client;
}
