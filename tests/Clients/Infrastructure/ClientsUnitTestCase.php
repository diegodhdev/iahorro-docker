<?php

declare(strict_types=1);

namespace Tests\Clients\Infrastructure;


use Backend\Clients\Domain\Client;
use Backend\Clients\Domain\ClientRepository;
use Mockery\MockInterface;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

abstract class ClientsUnitTestCase extends UnitTestCase
{

    protected function shouldSave(Client $client): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->with($this->similarTo($client))
            ->once()
            ->andReturnNull();
    }

    protected function shouldFindByEmail(Client $client): void
    {
        $this->repository()
            ->shouldReceive('findByEmail')
            ->with($this->similarTo($client->email()))
            ->once()
            ->andReturn($client);
    }

    protected function shouldNotFindByEmail(Client $client): void
    {
        $this->repository()
            ->shouldReceive('findByEmail')
            ->with($this->similarTo($client->email()))
            ->once()
            ->andReturn(null);
    }

    protected function repository(): ClientRepository|MockInterface
    {
        return $this->repository ??= $this->mock(ClientRepository::class);
    }

}
