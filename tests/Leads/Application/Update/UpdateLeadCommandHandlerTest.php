<?php

declare(strict_types=1);

namespace Tests\Leads\Application\Update;

use Backend\Leads\Application\Update\LeadUpdater;
use Backend\Leads\Application\Update\UpdateLeadCommand;
use Backend\Leads\Application\Update\UpdateLeadCommandHandler;
use Backend\Leads\Domain\LeadScore;
use Backend\Shared\Domain\Bus\CommandBus;
use Tests\Leads\Domain\LeadMother;
use Tests\Leads\Infrastructure\LeadsUnitTestCase;

class UpdateLeadCommandHandlerTest extends LeadsUnitTestCase
{
    private UpdateLeadCommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new UpdateLeadCommandHandler(new LeadUpdater($this->repository()));
    }

    /** @test */
    public function it_should_update_a_valid_lead(): void
    {
        $lead = LeadMother::create();

        $command = new UpdateLeadCommand(
            $lead->id()->value(),
            $lead->name()->value(),
            $lead->email()->value(),
            $lead->phone()->value(),
        );

        $this->shouldFindById($lead);
        $this->shouldUpdate($lead);

        $this->dispatch($command, $this->handler);
    }
}
