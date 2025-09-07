<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Mostrar página de login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home.index');
        }
        
        return view('auth.login');
    }

    /**
     * Processar login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'O email é obrigatório',
            'email.email' => 'Digite um email válido',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('home.index'))->with('success', 'Login realizado com sucesso!');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não conferem com nossos registros.',
        ])->withInput();
    }

    /**
     * Mostrar página de registro
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home.index');
        }
        
        return view('auth.register');
    }

    /**
     * Processar registro
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'email.email' => 'Digite um email válido',
            'email.unique' => 'Este email já está em uso',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres',
            'password.confirmed' => 'A confirmação da senha não confere',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home.index')->with('success', 'Conta criada com sucesso!');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Logout realizado com sucesso!');
    }

    /**
     * Redirecionar para Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Callback do Google OAuth
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(24)), // Senha aleatória
                    'email_verified_at' => now(),
                ]);
            }
            
            Auth::login($user, true);
            
            return redirect()->route('home.index')->with('success', 'Login com Google realizado com sucesso!');
            
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Erro ao fazer login com Google. Tente novamente.',
            ]);
        }
    }

    /**
     * Redirecionar para GitHub OAuth
     */
    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Callback do GitHub OAuth
     */
    public function handleGitHubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();
            
            $user = User::where('email', $githubUser->getEmail())->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $githubUser->getName() ?: $githubUser->getNickname(),
                    'email' => $githubUser->getEmail(),
                    'password' => Hash::make(Str::random(24)), // Senha aleatória
                    'email_verified_at' => now(),
                ]);
            }
            
            Auth::login($user, true);
            
            return redirect()->route('home.index')->with('success', 'Login com GitHub realizado com sucesso!');
            
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Erro ao fazer login com GitHub. Tente novamente.',
            ]);
        }
    }
}