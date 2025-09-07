<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    /**
     * Mostrar página de configurações
     */
    public function settings()
    {
        $user = Auth::user();
        return view('profile.settings', compact('user'));
    }

    /**
     * Atualizar perfil
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
            // Public profile fields
            'is_public' => 'boolean',
            'profile_type' => 'in:professional,personal',
            'username' => 'nullable|string|max:50|unique:users,username,' . $user->id . '|regex:/^[a-zA-Z0-9_-]+$/',
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'linkedin' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'github_username' => 'nullable|string|max:100',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:50',
            'experience' => 'nullable|array',
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'email.email' => 'Digite um email válido',
            'email.unique' => 'Este email já está em uso',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres',
            'password.confirmed' => 'A confirmação da senha não confere',
            'username.unique' => 'Este nome de usuário já está em uso',
            'username.regex' => 'O nome de usuário pode conter apenas letras, números, _ e -',
            'website.url' => 'Digite uma URL válida',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Verificar senha atual se fornecida
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'A senha atual está incorreta.',
                ])->withInput();
            }
        }

        // Atualizar dados do usuário
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        // Update public profile fields
        $user->is_public = $request->boolean('is_public', false);
        $user->profile_type = $request->get('profile_type', 'professional');
        $user->username = $request->get('username');
        $user->bio = $request->get('bio');
        $user->location = $request->get('location');
        $user->website = $request->get('website');
        $user->linkedin = $request->get('linkedin');
        $user->twitter = $request->get('twitter');
        $user->github_username = $request->get('github_username');
        
        // Handle skills array
        if ($request->has('skills')) {
            $skills = array_filter($request->get('skills', []));
            $user->skills = !empty($skills) ? $skills : null;
        }
        
        // Handle experience array
        if ($request->has('experience')) {
            $experience = array_filter($request->get('experience', []), function($exp) {
                return !empty($exp['company']) && !empty($exp['position']);
            });
            $user->experience = !empty($experience) ? array_values($experience) : null;
        }
        
        $user->save();

        return redirect()->route('profile.settings')->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Deletar conta
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
        ], [
            'password.required' => 'Digite sua senha para confirmar a exclusão da conta.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'A senha está incorreta.',
            ]);
        }

        // Deletar dados relacionados (opcional - você pode querer manter para auditoria)
        $user->projects()->delete();
        $user->tasks()->delete();
        $user->timeTrackings()->delete();
        
        // Deletar usuário
        $user->delete();

        return redirect()->route('login')->with('success', 'Sua conta foi excluída com sucesso.');
    }
}