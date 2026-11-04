<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Sistema de Entregas')</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f5f7; color: #222; }
        header { background: #1f2937; padding: 16px 32px; }
        header a { color: #fff; text-decoration: none; font-weight: bold; margin-right: 24px; }
        main { max-width: 1000px; margin: 32px auto; background: #fff; padding: 24px 32px; border-radius: 8px; }
        h1 { margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #e5e7eb; }
        th { background: #f9fafb; }
        .btn { display: inline-block; padding: 8px 14px; border: none; border-radius: 6px; background: #2563eb; color: #fff; text-decoration: none; cursor: pointer; font-size: 14px; }
        .btn-verde { background: #16a34a; }
        .btn-vermelho { background: #dc2626; }
        .btn-cinza { background: #6b7280; }
        .acoes { display: flex; gap: 6px; }
        .acoes form { margin: 0; }
        .alerta { padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; }
        .alerta-sucesso { background: #dcfce7; color: #166534; }
        .alerta-erro { background: #fee2e2; color: #991b1b; }
        label { display: block; margin-top: 14px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; margin-top: 6px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: #fff; }
        .paginacao { margin-top: 16px; }
    </style>
</head>
<body>
    <header>
        <a href="{{ route('clientes.index') }}">Clientes</a>
<a href="{{ route('pedidos.index') }}">Pedidos</a>
    </header>

    <main>
        @if (session('sucesso'))
            <div class="alerta alerta-sucesso">{{ session('sucesso') }}</div>
        @endif

        @if ($errors->any())
            <div class="alerta alerta-erro">
                <ul style="margin:0; padding-left:20px;">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('conteudo')
    </main>
</body>
</html>
