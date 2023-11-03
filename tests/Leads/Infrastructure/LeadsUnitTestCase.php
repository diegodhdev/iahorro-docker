<?php

declare(strict_types=1);

namespace Tests\Leads\Infrastructure;

use Backend\Leads\Domain\Lead;
use Backend\Leads\Domain\LeadId;
use Backend\Leads\Domain\LeadRepository;
use Backend\Leads\Domain\LeadScoringService;
use Mockery\MockInterface;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

abstract class LeadsUnitTestCase extends UnitTestCase
{

    protected function shouldSave(Lead $lead): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->with($this->similarTo($lead))
            ->once()
            ->andReturnNull();
    }

    protected function shouldUpdate(Lead $lead): void
    {
        $this->repository()
            ->shouldReceive('update')
            ->with($this->similarTo($lead))
            ->once()
            ->andReturnNull();
    }

    protected function shouldDelete(Lead $lead): void
    {
        $this->repository()
            ->shouldReceive('delete')
            ->with($this->similarTo($lead))
            ->once()
            ->andReturnNull();
    }

    protected function shouldFindById(Lead $lead): void
    {
        $this->repository()
            ->shouldReceive('findById')
            ->with($this->similarTo($lead->id()))
            ->once()
            ->andReturn($lead);
    }

    protected function shouldNotFindById(LeadId $leadId): void
    {
        $this->repository()
            ->shouldReceive('findById')
            ->with($this->similarTo($leadId))
            ->once()
            ->andReturn(null);
    }

    protected function shouldQueryById(Lead $lead): void
    {
        $this->queryBus()
        ->shouldReceive('query')
        ->with($this->similarTo($lead->id()))
        ->once()
        ->andReturn($lead);
    }

    protected function shouldCallScoringServiceWithAValidResponse(Lead $lead, float $result): void
    {
        $this->scoringService()
            ->shouldReceive('getLeadScore')
            ->with($this->similarTo($lead))
            ->once()
            ->andReturn($result);
    }

    protected function repository(): LeadRepository|MockInterface
    {
        return $this->repository ??= $this->mock(LeadRepository::class);
    }

    protected function scoringService(): LeadScoringService|MockInterface
    {
        return $this->scoringService ??= $this->mock(LeadScoringService::class);
    }

    protected function generateLongString(): string
    {
        $longString = '';
        for ($i = 0; $i < 255; $i++) {
            $longString .= chr(random_int(97, 122));
        }
        return $longString;
    }
}
