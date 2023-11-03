<?php

declare(strict_types=1);

namespace Tests\Leads\Application\Get;

use Backend\Leads\Application\Get\GetLeadQuery;
use Backend\Leads\Application\Get\GetLeadQueryHandler;
use Backend\Leads\Application\Get\LeadGetter;
use Backend\Leads\Application\Get\LeadGetterResponse;
use Backend\Leads\Domain\LeadId;
use Backend\Leads\Domain\LeadNotFoundException;
use Backend\Leads\Domain\LeadScore;
use SmoothPhp\QueryBus\QueryBus;
use Tests\Leads\Domain\LeadIdMother;
use Tests\Leads\Domain\LeadMother;
use Tests\Leads\Infrastructure\LeadsUnitTestCase;
use Tests\Shared\Domain\UuidMother;

class GetLeadCommandHandlerTest extends LeadsUnitTestCase
{
    private GetLeadQueryHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new GetLeadQueryHandler(new LeadGetter($this->repository()));
    }

    /** @test */
    public function it_should_get_a_valid_lead(): void
    {
        $lead = LeadMother::modify(null, null, null, null, new LeadScore(9.5));
        $query = new GetLeadQuery($lead->id()->value());

        $this->shouldFindById($lead);
        /**
         * @var LeadGetterResponse $response
         */
        $response = $this->query($query, $this->handler);

        $this->assertEquals($lead->id()->value(), $response->lead()['id']);
    }

    /** @test */
    public function it_should_raise_a_lead_not_found_exception(): void
    {
        $leadId = LeadIdMother::create();
        $query = new GetLeadQuery($leadId->value());

        $this->shouldNotFindById($leadId);
        $this->expectException(LeadNotFoundException::class);

        /**
         * @var LeadGetterResponse $response
         */
        $response = $this->query($query, $this->handler);
    }
}
