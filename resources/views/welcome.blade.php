<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NERDINO - Gerenciador de Projetos Dev</title>
    <style>
        body { 
            font-family: system-ui, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #f9fafb; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container { 
            max-width: 600px; 
            text-align: center; 
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h1 { color: #8b5cf6; margin-bottom: 20px; }
        .btn { 
            display: inline-block; 
            padding: 12px 24px; 
            background: #8b5cf6; 
            color: white; 
            text-decoration: none; 
            border-radius: 8px; 
            margin: 10px; 
            transition: background 0.3s;
        }
        .btn:hover { background: #7c3aed; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 NERDINO</h1>
        <h2>Gerenciador de Projetos Dev</h2>
        <p>Plataforma completa para desenvolvedores gerenciarem seus projetos, tarefas e portfólio.</p>
        
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="btn">Ir para Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn">Entrar</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn">Registrar</a>
                @endif
            @endauth
        @endif
    </div>
</body>
</html>
