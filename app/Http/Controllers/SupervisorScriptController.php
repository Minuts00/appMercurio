<?php

namespace App\Http\Controllers;

use App\Models\Objection;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Script;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SupervisorScriptController extends Controller
{
    public function create(): View
    {
         $categories = Category::query()
            ->with('subcategories')
            ->orderBy('name')
            ->get();

        $subcategoriesByCategory = $categories
            ->mapWithKeys(fn ($category) => [
                $category->id => $category->subcategories
                    ->map(fn ($subcategory) => [
                        'id' => $subcategory->id,
                        'name' => $subcategory->name,
                    ])
                    ->values(),
            ]);
        return view('Supervisors.Scripts.create', [
            'campaigns' => Campaign::query()->orderBy('name')->get(),
            'categories' => $categories,
            'subcategoriesByCategory' => $subcategoriesByCategory,
        ]);
    }

     public function createObjectionView()
    {
        $categories = Category::with('subcategories')->orderBy('name')->get();
        $campaigns = Campaign::orderBy('name')->get();

        $subcategoriesByCategory = $categories
            ->mapWithKeys(fn ($category) => [
                $category->id => $category->subcategories
                    ->map(fn ($subcategory) => [
                        'id' => $subcategory->id,
                        'name' => $subcategory->name,
                    ])
                    ->values(),
            ]);

        return view('supervisor-objections-upload', [
            'categories' => $categories,
            'campaigns' => $campaigns,
            'subcategoriesByCategory' => $subcategoriesByCategory,
        ]);
    }

    public function storeFromView(Request $request): RedirectResponse
    {
        $validated = $this->validateScriptPayload($request);

        Script::create($validated);

        return back()->with('status', 'Script salvato con successo.');
    }
    
    public function storeScript(Request $request): JsonResponse
    {
        $validated = $this->validateScriptPayload($request);

        $script = Script::create($validated);

        return response()->json([
            'message' => 'Script salvato con successo.',
            'data' => $script,
        ], 201);
    }

    private function validateScriptPayload(Request $request): array
    {
        return $request->validate([
            'id_category' => ['required', 'integer', 'exists:categories,id'],
            'id_subcategory' => [
                'required',
                'integer',
                Rule::exists('subcategories', 'id')->where(function ($query) use ($request) {
                    $query->where('id_category', $request->input('id_category'));
                }),
            ],
            'responses' => ['required', 'string', 'max:65000'],
            'id_campaign' => ['required', 'integer', 'exists:campaigns,id'],
        ]);
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