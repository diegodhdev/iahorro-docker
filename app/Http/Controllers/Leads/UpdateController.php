<?php

namespace App\Http\Controllers\Leads;

use App\Http\Controllers\Controller;
use Backend\Leads\Application\Update\UpdateLeadCommand;
use Backend\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class UpdateController extends Controller
{
    public function __construct(private readonly CommandBus $bus)
    {
    }

    public function __invoke(Request $request): \Illuminate\Http\Response
    {
        $request->validate([
            'id' => 'required|string|uuid',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $id    = $request->id;
        $name  = $request->name;
        $email = $request->email;
        $phone = null;
        if ($request->has('phone')) {
            $phone = $request->phone;
        }

        $command = new UpdateLeadCommand($id, $name, $email, $phone);

        $this->bus->dispatch($command);

        return new Response('Leads updated successfully', Response::HTTP_OK);
    }
}
