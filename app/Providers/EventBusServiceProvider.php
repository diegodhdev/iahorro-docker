<?php

namespace App\Providers;

use ArrayIterator;
use Backend\Clients\Application\CreateClientOnLeadStoredEvent;
use Backend\Shared\Domain\Bus\EventBus;
use Backend\Shared\Infrastructure\Bus\DomainEventMapping;
use Backend\Shared\Infrastructure\Bus\DomainEventSubscriberLocator;
use Backend\Shared\Infrastructure\Bus\InMemorySymfonyEventBus;
use Illuminate\Support\ServiceProvider;

class EventBusServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $subscribers = new ArrayIterator([
            $this->app->make(CreateClientOnLeadStoredEvent::class),
        ]);

        // Generic binding for EventBus
        $this->app->bind(
            DomainEventSubscriberLocator::class,
            fn ($app): DomainEventSubscriberLocator => new DomainEventSubscriberLocator($subscribers)
        );

        $this->app->bind(
            DomainEventMapping::class,
            fn ($app): DomainEventMapping => new DomainEventMapping(
                $subscribers
            )
        );

        $this->getInMemorySpecificConfigForEventBus($subscribers);
        $this->app->bind(EventBus::class, InMemorySymfonyEventBus::class);
    }

    public function getInMemorySpecificConfigForEventBus($subscribers): void
    {
        $this->app->bind(
            InMemorySymfonyEventBus::class,
            fn ($app): InMemorySymfonyEventBus => new InMemorySymfonyEventBus($subscribers)
        );
    }

}
