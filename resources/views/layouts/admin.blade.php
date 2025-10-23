<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Bluefish')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="admin-logo">
                <a href="{{ route('admin.index') }}" style="text-decoration:none;color:inherit;font-weight:600;">Bluefish Admin</a>
            </div>
            <ul class="admin-menu">
                <li class="admin-menu-item">
                    <a href="{{ route('admin.dashboard') }}" class="admin-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-gauge"></i> Painel
                    </a>
                </li>
                <li class="admin-menu-item">
                    <a href="{{ route('admin.products.index') }}" class="admin-menu-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="fas fa-fish"></i> Produtos
                    </a>
                </li>
                <li class="admin-menu-item">
                    <a href="{{ route('admin.users.index') }}" class="admin-menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Usuários
                    </a>
                </li>
            </ul>
        </aside>
        <main class="admin-content">
            @yield('content')
        </main>
    </div>
    @yield('scripts')
</body>
</html>


