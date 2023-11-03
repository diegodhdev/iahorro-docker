<?php

declare(strict_types=1);

namespace Backend\Leads\Infrastructure;

use Backend\Leads\Domain\Lead;
use Backend\Leads\Domain\LeadScoringService;
use Exception;
use GuzzleHttp\Client;

final class SpecificLeadScoringService implements LeadScoringService
{
    public function __construct(private readonly string $externalServiceUrl) {}

    final public const MAXIMUM_SCORE = 9.5;
    final public const MEDIUM_SCORE = 5.5;

    public function getLeadScore(Lead $lead): float
    {
        try {

            // Http Request to a random endpoint to simulate the service as external
            $client = new Client();
            $client->request('GET', $this->externalServiceUrl);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        // Fake logic to create the service
        if (!empty($lead->phone()->value())) {
            return self::MAXIMUM_SCORE;
        }

        return self::MEDIUM_SCORE;
    }
}
