<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Medical Inventory System')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body>
    @auth
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i class="fas fa-hospital-alt"></i>
                <span>Smart Medical Inventory</span>
            </div>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('inventory.index') }}" class="nav-item {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                <i class="fas fa-boxes"></i>
                <span>Inventory</span>
            </a>

            <div class="nav-group">
                <div class="nav-group-title">Stock Management</div>
                <a href="{{ route('stock.add.form') }}" class="nav-item {{ request()->routeIs('stock.add*') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i>
                    <span>Add Stock</span>
                </a>
                <a href="{{ route('stock.consume.form') }}" class="nav-item {{ request()->routeIs('stock.consume*') ? 'active' : '' }}">
                    <i class="fas fa-minus-circle"></i>
                    <span>Consume Stock</span>
                </a>
                <a href="{{ route('stock.transfer.form') }}" class="nav-item {{ request()->routeIs('stock.transfer*') ? 'active' : '' }}">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transfer Stock</span>
                </a>
                <a href="{{ route('stock.transfers') }}" class="nav-item">
                    <i class="fas fa-history"></i>
                    <span>Transfer History</span>
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Alerts</div>
                <a href="{{ route('alerts.index') }}" class="nav-item {{ request()->routeIs('alerts.index') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i>
                    <span>All Alerts</span>
                </a>
                <a href="{{ route('alerts.shortage') }}" class="nav-item {{ request()->routeIs('alerts.shortage') ? 'active' : '' }}">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Shortage Alerts</span>
                </a>
                <a href="{{ route('alerts.expiry') }}" class="nav-item {{ request()->routeIs('alerts.expiry') ? 'active' : '' }}">
                    <i class="fas fa-calendar-times"></i>
                    <span>Expiry Alerts</span>
                </a>
            </div>

            @if(auth()->user()->hasRole(['superadmin', 'admin']))
            <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>User Management</span>
            </a>
            @endif

            <a href="{{ route('export.index') }}" class="nav-item {{ request()->routeIs('export.*') ? 'active' : '' }}">
                <i class="fas fa-file-export"></i>
                <span>Export Data</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="user-details">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="topbar-right">
                <div class="notification-bell">
                    <i class="fas fa-bell"></i>
                    <span class="badge">{{ \App\Models\Alert::unread()->count() }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="content">
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @yield('content')
        </main>
    </div>
    @endauth

    @guest
    @yield('content')
    @endguest

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
