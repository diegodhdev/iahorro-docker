<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Client;
use App\Services\LeadScoringService;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    private $leadScoringService;

    public function __construct()
    {
        $this->leadScoringService = new LeadScoringService();
    }

    public function create()
    {
        return view('leads.create');
    }

    public function store(Request $request): string
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients',
            'phone' => 'nullable|string|max:20',
        ]);

        $l = new Lead();
        $l->name = $data['name'];
        $l->email = $data['email'];
        $l->phone = $data['phone'];
        $l->save();

        $c = new Client();
        $c->lead_id = $l->id;
        $c->save();

        // Interact with external lead scoring system
        $leadScoringService = new LeadScoringService();
        $score = $leadScoringService->getLeadScore($l);
        $l->score = $score;
        $l->save();

        return 'Leads created successfully';
    }

    public function show($id)
    {
        $lead = Lead::find($id);
        if (!$lead) {
            return 'Leads not found';
        }
        return view('leads.show', ['lead' => $lead]);
    }

    public function edit($id)
    {
        $lead = Lead::find($id);
        if (!$lead) {
            return 'Leads not found';
        }
        return view('leads.edit', ['lead' => $lead]);
    }

    public function update(Request $request, $id): string
    {
        $lead = Lead::find($id);
        if (!$lead) {
            return 'Leads not found';
        }

        $lead->name = $request->get('name');
        $lead->email = $request->get('email');
        $lead->phone = $request->get('phone');
        $lead->save();

        // Send lead to scoring system
        $score = $this->leadScoringService->getLeadScore($lead);

        return 'Leads updated successfully';
    }

    public function destroy($id): string
    {
        $lead = Lead::find($id);
        if (!$lead) {
            return 'Leads not found';
        }
        $lead->delete();
        return 'Leads deleted successfully';
    }
}
