<?php

declare(strict_types=1);

namespace Backend\Clients\Application;

use Backend\Clients\Domain\Client;
use Backend\Clients\Domain\ClientEmail;
use Backend\Clients\Domain\ClientLeadId;
use Backend\Clients\Domain\ClientRepository;
use Backend\Clients\Domain\EmailDuplicatedException;

final class ClientCreator
{
    public function __construct(private readonly ClientRepository $clientRepository) {}

    public function __invoke(string $email, string $leadId)
    {
        $client = Client::create(new ClientEmail($email), new ClientLeadId($leadId));

        $this->ensureEmailIsUnique($client);
        $this->clientRepository->save($client);
    }

    private function ensureEmailIsUnique(Client $client): void
    {
        $client = $this->clientRepository->findByEmail($client->email());

        if ($client) {
            throw new EmailDuplicatedException(sprintf('Email "%s" already exists.', $client->email()->value()));
        }
    }
}
