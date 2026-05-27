<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $adminStats = null;

        if ($user && $user->isAdmin()) {
            $adminStats = [
                'totalUsers' => User::count(),
                'adminCount' => User::whereHas('role', fn ($q) => $q->where('slug', Role::ADMIN))->count(),
                'employeeCount' => User::whereHas('role', fn ($q) => $q->where('slug', Role::EMPLOYEE))->count(),
                'userCount' => User::whereHas('role', fn ($q) => $q->where('slug', Role::USER))->count(),
            ];
        }

        return view('profile', [
            'user' => $user,
            'adminStats' => $adminStats,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Введите текущий пароль.',
            'password.required' => 'Введите новый пароль.',
            'password.confirmed' => 'Пароль и подтверждение не совпадают.',
            'password.min' => 'Пароль должен быть не менее :min символов.',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Неверный текущий пароль.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile')->with('success', 'Пароль успешно изменён.');
    }
}
