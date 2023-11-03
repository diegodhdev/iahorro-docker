<?php

declare(strict_types=1);

namespace Backend\Clients\Infrastructure;

use App\Models\Client as EloquentClient;
use Backend\Clients\Domain\Client;
use Backend\Clients\Domain\ClientEmail;
use Backend\Clients\Domain\ClientLeadId;
use Backend\Clients\Domain\ClientRepository;

final class EloquentClientRepository implements ClientRepository
{
    public function save(Client $client): void
    {
        $eloquentClient = new EloquentClient();

        $eloquentClient->email = $client->email()->value();
        $eloquentClient->lead_id = $client->leadId()->value();

        $eloquentClient->save();
    }

    public function update(Client $client): void
    {
        $eloquentLead = EloquentClient::where('email', $client->email()->value())->first();

        $eloquentLead->email = $client->email()->value();
        $eloquentLead->lead_id = $client->leadId()->value();
        $eloquentLead->save();
    }

    public function findByEmail(ClientEmail $email): ?Client
    {
        $eloquentLead = EloquentClient::where('email', $email->value())->first();

        if (!$eloquentLead) {
            return null;
        }


        return Client::create(new ClientEmail($eloquentLead->email), new ClientLeadId($eloquentLead->lead_id));
    }
}
