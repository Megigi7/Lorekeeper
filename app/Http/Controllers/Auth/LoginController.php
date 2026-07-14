<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Muestra la vista con el formulario humorístico de acceso.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesa el intento de inicio de sesión.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentamos autenticar con las credenciales y recordando la sesión
        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();

            // Si es correcto, te mandamos al Olimpo administrativo
            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, O Mighty Creator!');
        }

        // Si falla, volvemos atrás con un mensaje gracioso de error
        return back()->withErrors([
            'email' => 'Are you sure you are the real Wiwi Master? The credentials do not match.',
        ])->onlyInput('email');
    }

    /**
     * Cierra la sesión del administrador.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'Logged out. Back to normal mortal mode.');
    }
}