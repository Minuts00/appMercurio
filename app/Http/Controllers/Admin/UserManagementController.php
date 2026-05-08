<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', Rule::exists('roles', 'name')],
            'id_campaign' => ['nullable', 'integer', 'exists:campaigns,id'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $user = new User();
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->id_campaign = $validated['id_campaign'] ?? null;
        $user->is_active = $validated['is_active'] ?? true;
        $user->save();

        $role = Role::query()->where('name', $validated['role'])->firstOrFail();
        $user->assignRole($role);

        return response()->json([
            'message' => 'Utente creato con successo.',
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'id_campaign' => $user->id_campaign,
                'is_active' => $user->is_active,
                'role' => $validated['role'],
            ],
        ], 201);
    }
}