<?php

declare(strict_types=1);

namespace Tests\Clients\Infrastructure;


use Backend\Clients\Domain\Client;
use Backend\Clients\Infrastructure\EloquentClientRepository;
use Tests\Clients\Domain\ClientMother;


class EloquentClientRepositoryTest extends ClientsUnitTestCase
{
    private EloquentClientRepository $eloquentRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eloquentRepository = $this->app->make(EloquentClientRepository::class);
    }

    /** @test */
    public function it_should_create_a_valid_client(): void
    {
        $client = ClientMother::create();
        $this->eloquentRepository->save($client);

        /**
         * @var Client $response
         */
        $response = $this->eloquentRepository->findByEmail($client->email());

        $this->assertTrue($client->email()->value() == $response->email()->value());
    }
}
