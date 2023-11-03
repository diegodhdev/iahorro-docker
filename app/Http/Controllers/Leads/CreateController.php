<?php

namespace App\Http\Controllers\Leads;

use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function __invoke()
    {
        return view('leads.create');
    }
}
