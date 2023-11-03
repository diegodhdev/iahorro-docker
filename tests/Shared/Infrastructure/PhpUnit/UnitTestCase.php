<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\PhpUnit;

use Backend\Leads\Application\Get\GetLeadQueryHandler;
use Backend\Shared\Domain\Bus\Command;
use Backend\Shared\Domain\Bus\DomainEvent;
use Backend\Shared\Domain\Bus\EventBus;
use Backend\Shared\Domain\Bus\Query;
use Backend\Shared\Domain\Bus\QueryHandler;
use Backend\Shared\Infrastructure\Bus\QueryResponse;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Matcher\MatcherAbstract;
use Mockery\MockInterface;

use SmoothPhp\QueryBus\QueryBus;
use Tests\CreatesApplication;
use Tests\Shared\Domain\TestUtils;

abstract class UnitTestCase extends MockeryTestCase
{
    use CreatesApplication;


    protected Application $app;


    protected function setUp(): void
    {
        parent::setUp();
        $this->app = $this->createApplication();
        DB::beginTransaction();
    }

    final public function tearDown(): void
    {
        DB::rollBack();
        DB::disconnect();
        parent::tearDown();
    }

    protected function mock(string $className): MockInterface
    {
        return Mockery::mock($className);
    }

    protected function shouldPublishDomainEvent(DomainEvent $domainEvent): void
    {
        $this->eventBus()
            ->shouldReceive('publish')
            ->with($this->similarTo($domainEvent))
            ->once();
    }

    protected function shouldNotPublishDomainEvent(): void
    {
        $this->eventBus()
            ->shouldReceive('publish')
            ->withNoArgs()
            ->andReturnNull();
    }

    protected function isSimilar(mixed $expected, mixed $actual): bool
    {
        return TestUtils::isSimilar($expected, $actual);
    }

    protected function assertSimilar(mixed $expected, mixed $actual): void
    {
        TestUtils::assertSimilar($expected, $actual);
    }

    protected function similarTo(mixed $value, float $delta = 0.0): MatcherAbstract
    {
        return TestUtils::similarTo($value, $delta);
    }

    protected function eventBus(): EventBus|MockInterface
    {
        return $this->eventBus ??= $this->mock(EventBus::class);
    }

    protected function queryBus(): QueryBus|MockInterface
    {
        return $this->queryBus ??= $this->mock(QueryBus::class);
    }

    protected function dispatch(Command $command, callable $commandHandler): void
    {
        $commandHandler($command);
    }

    protected function query(Query $query, QueryHandler $queryHandler): QueryResponse
    {
        return $queryHandler->handle($query);
    }
}
