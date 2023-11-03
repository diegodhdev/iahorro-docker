<?php

namespace App\Http\Controllers\Leads;

use App\Http\Controllers\Controller;
use Backend\Leads\Application\Get\GetLeadQuery;
use Backend\Leads\Application\Get\LeadGetterResponse;
use SmoothPhp\QueryBus\QueryBus;

class ShowController extends Controller
{
    public function __construct(private readonly QueryBus $bus)
    {
    }

    public function __invoke(string $id)
    {
        /**
         * @var LeadGetterResponse $response
         */
        $response = $this->bus->query(new GetLeadQuery($id));

        return view('leads.show', ['lead' => $response->lead()]);
    }
}
