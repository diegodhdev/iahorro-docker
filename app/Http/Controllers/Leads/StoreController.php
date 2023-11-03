<?php

declare(strict_types=1);

namespace App\Http\Controllers\Leads;

use App\Http\Controllers\Controller;
use Backend\Leads\Application\Store\StoreLeadCommand;
use Backend\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class StoreController extends Controller
{
    public function __construct(private readonly CommandBus $bus)
    {
    }

    public function __invoke(Request $request): \Illuminate\Http\Response
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients',
            'phone' => 'nullable|string|max:20',
        ]);

        $id    = Uuid::uuid4()->toString();
        $name  = $request->name;
        $email = $request->email;
        $phone = null;
        if ($request->has('phone')) {
            $phone = $request->phone;
        }

        $command = new StoreLeadCommand($id, $name, $email, $phone);

        $this->bus->dispatch($command);

        return new Response('Leads created successfully', Response::HTTP_CREATED);
    }
}
