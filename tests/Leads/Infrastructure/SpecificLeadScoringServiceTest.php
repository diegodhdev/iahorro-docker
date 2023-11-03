<?php

declare(strict_types=1);

namespace Tests\Leads\Infrastructure;

use Backend\Leads\Domain\Lead;
use Backend\Leads\Infrastructure\EloquentLeadRepository;
use Backend\Leads\Infrastructure\SpecificLeadScoringService;
use Exception;
use GuzzleHttp\Client;
use Tests\Leads\Domain\LeadMother;

class SpecificLeadScoringServiceTest extends LeadsUnitTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_should_raise_a_generic_exception_when_calling_service(): void
    {
        $scoringService = new SpecificLeadScoringService("aaa");
        $lead = LeadMother::create();

        $this->expectException(Exception::class);
        $scoringService->getLeadScore($lead);
    }

    /** @test */
    public function it_should_return_a_valid_score_when_calling_service(): void
    {
        $scoringService = new SpecificLeadScoringService("https://fakestoreapi.com/products/1");
        $lead = LeadMother::create();


        $score = $scoringService->getLeadScore($lead);

        $this->assertIsFloat($score);
        $this->assertTrue($score >= 0 && $score <= 10);

    }

}
