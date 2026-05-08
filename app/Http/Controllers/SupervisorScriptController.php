<?php

namespace App\Http\Controllers;

use App\Models\Objection;
use App\Models\Script;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupervisorScriptController extends Controller
{
    public function storeScript(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id_category' => ['required', 'integer', 'exists:categories,id'],
            'id_subcategory' => [
                'required',
                'integer',
                Rule::exists('subcategories', 'id')->where(function ($query) use ($request) {
                    $query->where('id_category', $request->input('id_category'));
                }),
            ],
            'responses' => ['required', 'string', 'max:65535'],
            'id_campaign' => ['required', 'integer', 'exists:campaigns,id'],
        ]);

        $script = Script::create($validated);

        return response()->json([
            'message' => 'Script salvato con successo.',
            'data' => $script,
        ], 201);
    }

    public function storeObjection(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id_category' => ['required', 'integer', 'exists:categories,id'],
            'id_subcategory' => [
                'required',
                'integer',
                Rule::exists('subcategories', 'id')->where(function ($query) use ($request) {
                    $query->where('id_category', $request->input('id_category'));
                }),
            ],
            'responses' => ['required', 'string', 'max:65535'],
            'id_campaign' => ['required', 'integer', 'exists:campaigns,id'],
        ]);

        $objection = Objection::create($validated);

        return response()->json([
            'message' => 'Obiezione salvata con successo.',
            'data' => $objection,
        ], 201);
    }
}