<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (User::query()->exists()) {
            return redirect('/');
        }

        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        if (User::query()->exists()) {
            return redirect('/');
        }

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
        ]);

        $user = new User();
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->is_active = true;
        $user->save();

        $user->assignRole('admin');

        return redirect('/')->with('success', 'Admin creato con successo.');
    }
}