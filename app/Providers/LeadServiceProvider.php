<?php

namespace App\Providers;

use Backend\Clients\Domain\ClientRepository;
use Backend\Clients\Infrastructure\EloquentClientRepository;
use Backend\Leads\Application\Destroy\DestroyLeadCommand;
use Backend\Leads\Application\Destroy\DestroyLeadCommandHandler;
use Backend\Leads\Application\Store\StoreLeadCommand;
use Backend\Leads\Application\Store\StoreLeadCommandHandler;
use Backend\Leads\Application\Update\UpdateLeadCommand;
use Backend\Leads\Application\Update\UpdateLeadCommandHandler;
use Backend\Leads\Domain\LeadRepository;
use Backend\Leads\Domain\LeadScoringService;
use Backend\Leads\Infrastructure\EloquentLeadRepository;
use Backend\Leads\Infrastructure\SpecificLeadScoringService;
use Backend\Shared\Domain\Bus\CommandBus;
use Backend\Shared\Infrastructure\Bus\InMemorySymfonyCommandBus;
use Illuminate\Support\ServiceProvider;

class LeadServiceProvider extends ServiceProvider
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
        $this->app->bind(LeadRepository::class, EloquentLeadRepository::class);
        $this->app->bind(ClientRepository::class, EloquentClientRepository::class);

        $this->app->bind(
            InMemorySymfonyCommandBus::class,
            fn($app): InMemorySymfonyCommandBus => new InMemorySymfonyCommandBus(
                [
                    StoreLeadCommand::class => [$app->make(StoreLeadCommandHandler::class)],
                    UpdateLeadCommand::class => [$app->make(UpdateLeadCommandHandler::class)],
                    DestroyLeadCommand::class => [$app->make(DestroyLeadCommandHandler::class)],
                ],
            )
        );

        $this->app->bind(
            SpecificLeadScoringService::class,
            fn($app): SpecificLeadScoringService => new SpecificLeadScoringService(
                "https://fakestoreapi.com/products/1"
            )
        );

        $this->app->bind(CommandBus::class, InMemorySymfonyCommandBus::class);
        $this->app->bind(LeadScoringService::class, SpecificLeadScoringService::class);
    }
}
