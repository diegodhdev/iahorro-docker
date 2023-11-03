<?php

namespace App\Http\Controllers\Leads;

use App\Http\Controllers\Controller;
use Backend\Leads\Application\Get\GetLeadQuery;
use Backend\Leads\Application\Get\LeadGetterResponse;
use Illuminate\Http\Request;
use SmoothPhp\QueryBus\QueryBus;

class EditController extends Controller
{
    public function __construct(private readonly QueryBus $bus)
    {
    }

    public function __invoke(Request $request, string $id)
    {
        /**
         * @var LeadGetterResponse $response
         */
        $response = $this->bus->query(new GetLeadQuery($id));

        return view('leads.edit', ['lead' => $response->lead()]);
    }
}
