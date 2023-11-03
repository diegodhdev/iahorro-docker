<?php

namespace App\Http\Controllers\Leads;

use App\Http\Controllers\Controller;
use Backend\Leads\Application\Destroy\DestroyLeadCommand;
use Backend\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\Response;

class DestroyController extends Controller
{
    public function __construct(private readonly CommandBus $bus)
    {
    }

    public function __invoke(string $id): Response
    {

        $command = new DestroyLeadCommand($id);

        $this->bus->dispatch($command);

        return new Response('Leads deleted successfully', Response::HTTP_OK);
    }
}
