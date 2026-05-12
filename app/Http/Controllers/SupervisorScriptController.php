<?php

namespace App\Http\Controllers;

use App\Models\Objection;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Script;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SupervisorScriptController extends Controller
{
     public function userScriptsByCategory(string $categoryName): View
    {
        $userCampaignId = auth()->user()?->id_campaign;

        $scripts = Script::query()
            ->with(['category', 'subcategory', 'campaign'])
            ->whereHas('category', function ($query) use ($categoryName) {
                $query->whereRaw('LOWER(name) = ?', [strtolower($categoryName)]);
            })
            ->when($userCampaignId, fn ($query) => $query->where('id_campaign', $userCampaignId))
            ->when(!$userCampaignId, fn ($query) => $query->whereRaw('1 = 0'))
            ->orderBy('id_campaign')
            ->orderBy('id_subcategory')
            ->get();

        return view('scripts-by-category', [
            'categoryName' => $categoryName,
            'scripts' => $scripts,
        ]);
    }

    public function indexScripts(): JsonResponse
    {
        return response()->json([
            'data' => $this->visibleScriptsQuery()->get(),
        ]);
    }

    public function indexObjections(): JsonResponse
    {
        return response()->json([
            'data' => $this->visibleObjectionsQuery()->get(),
        ]);
    }

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
            'responses' => ['required', 'string', 'max:65000'],
            'id_campaign' => ['required', 'integer', 'exists:campaigns,id'],
        ]);

        $objection = Objection::create($validated);

        return response()->json([
            'message' => 'Obiezione salvata con successo.',
            'data' => $objection,
        ], 201);
    }
    private function visibleScriptsQuery()
    {
        $query = Script::query()->latest();
        $user = Auth::user();

        if ($user && ! $user->hasAnyRole(['admin', 'supervisor'])) {
            $query->where('id_campaign', $user->id_campaign);
        }

        return $query;
    }

    private function visibleObjectionsQuery()
    {
        $query = Objection::query()->latest();
        $user = Auth::user();

        if ($user && ! $user->hasAnyRole(['admin', 'supervisor'])) {
            $query->where('id_campaign', $user->id_campaign);
        }

        return $query;
    }
}