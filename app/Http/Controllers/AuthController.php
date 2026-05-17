<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validar entrada
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'lgpd_consent' => 'required|accepted',
        ], [
            'email.required' => 'Email é obrigatório.',
            'email.email' => 'Email inválido.',
            'password.required' => 'Senha é obrigatória.',
            'password.min' => 'Senha deve ter no mínimo 6 caracteres.',
            'lgpd_consent.required' => 'Você deve aceitar a política de LGPD.',
            'lgpd_consent.accepted' => 'Você deve aceitar a política de LGPD.',
        ]);

        // Tentar autenticar
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            // Atualizar consentimento LGPD
            Auth::user()->update([
                'lgpd_consent' => true,
                'lgpd_consent_at' => now(),
            ]);

            $request->session()->regenerate();
            return redirect()->intended('/alunos');
        }

        return back()->withErrors([
            'email' => 'Email ou senha inválidos.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
