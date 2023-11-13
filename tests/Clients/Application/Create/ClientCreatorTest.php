<?php

declare(strict_types=1);

namespace Tests\Clients\Application\Create;

use Backend\Clients\Application\ClientCreator;
use Backend\Clients\Domain\EmailDuplicatedException;
use Tests\Clients\Domain\ClientMother;
use Tests\Clients\Infrastructure\ClientsUnitTestCase;


class ClientCreatorTest extends ClientsUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->creator = new ClientCreator($this->repository());
    }

    /** @test */
    public function it_should_create_a_valid_client(): void
    {
        $client = ClientMother::create();

        $this->shouldNotFindByEmail($client);
        $this->shouldSave($client);

        $this->creator->__invoke($client->email()->value(), $client->leadId()->value());
    }

    /** @test */
    public function it_should_raise_a_duplicated_email_exception(): void
    {
        $client = ClientMother::create();

        $this->shouldFindByEmail($client);
        $this->expectException(EmailDuplicatedException::class);

        $this->creator->__invoke($client->email()->value(), $client->leadId()->value());
    }
}
