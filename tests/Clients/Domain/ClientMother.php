<?php

declare(strict_types=1);

namespace Tests\Clients\Domain;

use Backend\Clients\Domain\Client;
use Backend\Clients\Domain\ClientEmail;
use Backend\Clients\Domain\ClientId;
use Backend\Clients\Domain\ClientLeadId;

final class ClientMother
{

    public static function create(
        ?ClientEmail  $email = null,
        ?ClientLeadId $leadId = null,
    ): Client
    {
        return Client::create(
            $email ?? ClientEmailMother::create(),
            $leadId ?? ClientLeadIdMother::create(),
        );
    }
}
