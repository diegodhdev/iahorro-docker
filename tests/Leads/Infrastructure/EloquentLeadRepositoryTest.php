<?php

declare(strict_types=1);

namespace Tests\Leads\Infrastructure;


use Backend\Clients\Infrastructure\EloquentClientRepository;
use Backend\Leads\Domain\Lead;
use Backend\Leads\Infrastructure\EloquentLeadRepository;
use Tests\Leads\Domain\LeadMother;
use Tests\Leads\Domain\LeadNameMother;


class EloquentLeadRepositoryTest extends LeadsUnitTestCase
{
    private EloquentLeadRepository $eloquentRepository;

    /**
     * @return Lead
     */
    public function createLead(): Lead
    {
        $lead = LeadMother::create();
        $this->eloquentRepository->save($lead);
        return $lead;
    }

    /**
     * @return bool
     */
    public function hasSameId(Lead $lead, Lead $response): bool
    {
        return $lead->id()->value() == $response->id()->value();
    }

    /**
     * @return bool
     */
    public function hasDifferentName(Lead $lead, Lead $response): bool
    {
        return $lead->name()->value() != $response->name()->value();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->eloquentRepository = $this->app->make(EloquentLeadRepository::class);
    }

    /** @test */
    public function it_should_create_a_valid_lead(): void
    {
        $lead = $this->createLead();

        /**
         * @var Lead $response
         */
        $response = $this->eloquentRepository->findById($lead->id());

        $this->assertTrue($lead->email()->value() == $response->email()->value());
    }

    /** @test */
    public function it_should_update_a_valid_lead(): void
    {
        $lead = $this->createLead();
        $leadModify = Lead::modify($lead->id(), LeadNameMother::create('John Doe'), $lead->email(), null, $lead->score());

        $this->eloquentRepository->update($leadModify);

        /**
         * @var Lead $response
         */
        $response = $this->eloquentRepository->findById($leadModify->id());

        $this->assertTrue($this->hasSameId($lead, $response) && $this->hasDifferentName($lead, $response));
    }
}
