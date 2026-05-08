<?php

namespace App\Http\Controllers;

use App\Models\Anagraphic;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;


class AnagraphicController extends Controller
{
     public function adminIndex(): View
    {
        return view('Admin.Anagraphics.index', [
            'anagraphics' => Anagraphic::query()
                ->with('campaign:id,name')
                ->latest()
                ->paginate(20),
        ]);
    }
    
    public function create(): View
    {
        return view('anagraphics.create', [
            'campaigns' => Campaign::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function index(): JsonResponse
    {
        return response()->json(Anagraphic::query()->latest()->get());
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'fiscalCode' => ['nullable', 'string', 'max:255'],
            'identityDoc' => ['nullable', 'string', 'max:255'],
            'mail' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'POD' => ['nullable', 'string', 'max:255'],
            'PDR' => ['nullable', 'string', 'max:255'],
            'RID' => ['nullable', 'string', 'max:255'],
            'lightOffer' => ['nullable', 'string', 'max:255'],
            'gasOffer' => ['nullable', 'string', 'max:255'],
            'telco' => ['nullable', 'boolean'],
            'note' => ['nullable', 'string', 'max:255'],
            'boNote' => ['nullable', 'string', 'max:255'],
            'id_campaign' => ['required', 'integer', 'exists:campaigns,id'],
        ]);

        $anagraphic = Anagraphic::create($validated);

        if (! $request->expectsJson()) {
            return redirect()
                ->route('anagraphics.upload-form')
                ->with('status', 'Anagrafica caricata con successo.');
        }
        return response()->json($anagraphic, 201);
    }

    public function show(Anagraphic $anagraphic): JsonResponse
    {
        return response()->json($anagraphic);
    }

    public function edit(Anagraphic $anagraphic): View
    {
        return view('supervisors.anagraphics.edit', [
            'anagraphic' => $anagraphic,
            'campaigns' => Campaign::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function updateFromView(Request $request, Anagraphic $anagraphic): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'fiscalCode' => ['nullable', 'string', 'max:255'],
            'identityDoc' => ['nullable', 'string', 'max:255'],
            'mail' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'POD' => ['nullable', 'string', 'max:255'],
            'PDR' => ['nullable', 'string', 'max:255'],
            'RID' => ['nullable', 'string', 'max:255'],
            'lightOffer' => ['nullable', 'string', 'max:255'],
            'gasOffer' => ['nullable', 'string', 'max:255'],
            'telco' => ['nullable', 'boolean'],
            'note' => ['nullable', 'string', 'max:255'],
            'boNote' => ['nullable', 'string', 'max:255'],
            'id_campaign' => ['required', 'integer', 'exists:campaigns,id'],
        ]);

        $anagraphic->update($validated);

        return redirect()
            ->route('supervisor.anagraphics.edit', $anagraphic)
            ->with('status', 'Anagrafica aggiornata con successo.');
    }

    public function update(Request $request, Anagraphic $anagraphic): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'surname' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => ['sometimes', 'required', 'string', 'max:255'],
            'fiscalCode' => ['nullable', 'string', 'max:255'],
            'identityDoc' => ['nullable', 'string', 'max:255'],
            'mail' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'POD' => ['nullable', 'string', 'max:255'],
            'PDR' => ['nullable', 'string', 'max:255'],
            'RID' => ['nullable', 'string', 'max:255'],
            'lightOffer' => ['nullable', 'string', 'max:255'],
            'gasOffer' => ['nullable', 'string', 'max:255'],
            'telco' => ['nullable', 'boolean'],
            'note' => ['nullable', 'string', 'max:255'],
            'boNote' => ['nullable', 'string', 'max:255'],
            'id_campaign' => ['sometimes', 'required', 'integer', 'exists:campaigns,id'],
        ]);

        $anagraphic->update($validated);

        return response()->json($anagraphic);
    }

    public function destroy(Anagraphic $anagraphic): JsonResponse
    {
        $anagraphic->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}