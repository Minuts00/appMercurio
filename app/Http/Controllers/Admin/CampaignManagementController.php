<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CampaignManagementController extends Controller
{
    public function create(): View
    {
        return view('Admin.Campaigns.create', [
            'campaigns' => Campaign::query()->orderBy('name')->get(),
        ]);
    }

    public function store(): RedirectResponse
    {
        $validated = request()->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Campaign::create($validated);

        return redirect()
            ->route('admin.campaigns.create')
            ->with('success', 'Campagna caricata con successo.');
    }
}