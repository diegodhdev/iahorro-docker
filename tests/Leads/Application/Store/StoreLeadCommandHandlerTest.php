<?php

declare(strict_types=1);

namespace Tests\Leads\Application\Store;

use Backend\Leads\Application\Store\LeadStorer;
use Backend\Leads\Application\Store\StoreLeadCommand;
use Backend\Leads\Application\Store\StoreLeadCommandHandler;
use Backend\Leads\Domain\EmailNotValidException;
use Backend\Leads\Domain\Lead;
use Backend\Leads\Domain\LeadScore;
use Backend\Shared\Domain\Bus\CommandBus;
use Backend\Shared\Domain\HasNotValidSizeException;
use Tests\Leads\Domain\LeadMother;
use Tests\Leads\Domain\StoreLeadCommandMother;
use Tests\Leads\Infrastructure\LeadsUnitTestCase;
use Tests\Shared\Domain\MotherCreator;

class StoreLeadCommandHandlerTest extends LeadsUnitTestCase
{
    private StoreLeadCommandHandler $handler;
    private readonly CommandBus $bus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new StoreLeadCommandHandler(new LeadStorer($this->repository(), $this->eventBus(), $this->scoringService()));
    }

    /** @test */
    public function it_should_create_a_valid_lead(): void
    {
        $temp = LeadMother::create();

        $command = new StoreLeadCommand(
            $temp->id()->value(),
            $temp->name()->value(),
            $temp->email()->value(),
            $temp->phone()->value(),
        );

        $lead = LeadMother::fromRequest($command);

        $expectedScore = 9.5;
        $this->shouldSave($lead);
        $this->shouldCallScoringServiceWithAValidResponse($lead, $expectedScore);
        $this->shouldPublishDomainEvent(...$temp->pullDomainEvents());

        // Update
        $leadUpdate = Lead::modify($lead->id(), $lead->name(), $lead->email(), $lead->phone(), new LeadScore($expectedScore));
        $this->shouldUpdate($leadUpdate);

        $this->dispatch($command, $this->handler);
    }

    /** @test */
    public function it_should_raise_an_email_error_exception(): void
    {
        $command = StoreLeadCommandMother::create(null, null, 'wrong_email',null);

        $this->expectException(EmailNotValidException::class);
        $this->dispatch($command, $this->handler);
    }

    /** @test */
    public function it_should_raise_a_has_not_valid_size_exception_for_email(): void
    {
        $longEmail = $this->generateLongString().MotherCreator::random()->email;

        $commandEmailNotValidSize = StoreLeadCommandMother::create(null, null,$longEmail, null);
        $this->expectException(HasNotValidSizeException::class);

        $this->dispatch($commandEmailNotValidSize, $this->handler);
    }

    /** @test */
    public function it_should_raise_a_has_not_valid_size_exception_for_name(): void
    {
        $commandNameNotValidSize = StoreLeadCommandMother::create(null, '', null,null);

        $this->expectException(HasNotValidSizeException::class);

        $this->dispatch($commandNameNotValidSize, $this->handler);
    }

    /** @test */
    public function it_should_raise_a_has_not_valid_size_exception_for_phone(): void
    {
        $commandNameNotValidSize = StoreLeadCommandMother::create(null, null, null,$this->generateLongString());

        $this->expectException(HasNotValidSizeException::class);

        $this->dispatch($commandNameNotValidSize, $this->handler);
    }

}
