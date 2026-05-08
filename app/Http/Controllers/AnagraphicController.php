<?php

namespace App\Http\Controllers;

use App\Models\Anagraphic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnagraphicController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Anagraphic::query()->latest()->get());
    }

    public function store(Request $request): JsonResponse
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

        return response()->json($anagraphic, 201);
    }

    public function show(Anagraphic $anagraphic): JsonResponse
    {
        return response()->json($anagraphic);
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

        return response()->json(status: 204);
    }
}