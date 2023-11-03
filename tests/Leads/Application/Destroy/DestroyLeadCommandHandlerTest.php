<?php

declare(strict_types=1);

namespace Tests\Leads\Application\Destroy;

use Backend\Leads\Application\Destroy\DestroyLeadCommand;
use Backend\Leads\Application\Destroy\DestroyLeadCommandHandler;
use Backend\Leads\Application\Destroy\LeadDestroyer;
use Tests\Leads\Domain\LeadMother;
use Tests\Leads\Infrastructure\LeadsUnitTestCase;

class DestroyLeadCommandHandlerTest extends LeadsUnitTestCase
{
    private DestroyLeadCommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new DestroyLeadCommandHandler(new LeadDestroyer($this->repository()));
    }

    /** @test */
    public function it_should_destroy_a_valid_lead(): void
    {
        $lead = LeadMother::create();

        $command = new DestroyLeadCommand(
            $lead->id()->value(),
        );

        $this->shouldFindById($lead);
        $this->shouldDelete($lead);

        $this->dispatch($command, $this->handler);
    }
}
