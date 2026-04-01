<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- ✅ Bootstrap & FontAwesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- ✅ Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    {{-- ✅ Sidebar --}}
    <div class="sidebar">
        <div class="profile-card text-center p-3 border-bottom">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                 alt="Admin Avatar" class="rounded-circle mb-2" width="70" height="70">
            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
            <small class="text-muted">{{ Auth::user()->email }}</small>
        </div>

        <ul class="nav flex-column p-2">
            <li><a href="{{ url('/admin/dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-home me-2"></i> Dashboard</a></li>

            <li><a href="{{ url('/admin/users') }}" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                <i class="fas fa-users me-2"></i> User Management</a></li>

            <li><a href="{{ url('/admin/tasks') }}" class="nav-link {{ request()->is('admin/tasks') ? 'active' : '' }}">
                <i class="fas fa-tasks me-2"></i> Task Management</a></li>

            <li><a href="{{ url('/admin/reports') }}" class="nav-link {{ request()->is('admin/reports') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-2"></i> Reports & Analytics</a></li>

            <li><a href="{{ url('/admin/settings') }}" class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}">
                <i class="fas fa-cog me-2"></i> Settings</a></li>

            <li><a href="{{ url('/admin/activity-log') }}" class="nav-link {{ request()->is('admin/activity-log') ? 'active' : '' }}">
                <i class="fas fa-history me-2"></i> Activity Log</a></li>

            <li><a href="{{ url('/admin/support') }}" class="nav-link {{ request()->is('admin/support') ? 'active' : '' }}">
                <i class="fas fa-headset me-2"></i> Support</a></li>

            <form action="{{ url('/logout') }}" method="POST" class="mt-3 px-2">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </button>
            </form>
        </ul>
    </div>

    {{-- ✅ Theme Toggle --}}
    <button class="theme-toggle" id="themeToggle">
        <i class="fa fa-moon"></i>
    </button>

    {{-- ✅ Main Content --}}
    <div class="main-content">
        <nav class="navbar navbar-light bg-light rounded shadow-sm mb-4 px-3 d-flex justify-content-between align-items-center">
            <span class="navbar-brand mb-0 h5">@yield('title', 'Admin Dashboard')</span>
            <span class="text-muted small">Welcome, {{ Auth::user()->name }}</span>
        </nav>

        {{-- ✅ Page Content --}}
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    {{-- ✅ JS Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>

</body>
</html>
