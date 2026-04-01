<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="sidebar">
        <div class="profile-card">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin Avatar">
            <br>
            {{-- <small>{{ Auth::user()->name }}</small><br> --}}
            <small>{{ Auth::user()->email }}</small>
        </div>

        <ul class="nav flex-column">
            <li><a href="{{ url('/admin/dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="fas fa-home me-2"></i>Dashboard</a></li>
            <li><a href="{{ url('/admin/users') }}" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}"><i class="fas fa-users me-2"></i>User Management</a></li>
            <li><a href="{{ url('/admin/tasks') }}" class="nav-link {{ request()->is('admin/tasks') ? 'active' : '' }}"><i class="fas fa-tasks me-2"></i>Task Management</a></li>

            <li><a href="{{ url('/admin/reports') }}" class="nav-link"><i class="fas fa-chart-line me-2"></i>Reports & Analytics</a></li>
            <li><a href="{{ url('/admin/settings') }}" class="nav-link"><i class="fas fa-cog me-2"></i>Settings</a></li>
            <li><a href="{{ url('/admin/activity-log') }}" class="nav-link"><i class="fas fa-history me-2"></i>Activity Log</a></li>
            <li><a href="{{ url('/admin/support') }}" class="nav-link"><i class="fas fa-headset me-2"></i>Support</a></li>
            <li><a href="{{ url('/admin/logout') }}" class="nav-link"><i class="fa-solid fa-info"></i> Info</a></li>
             <form action="{{ url('/admin/logout') }}" method="POST" class="d-flex">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-sign-out-alt me-1 pd-2"></i> Logout
                </button>
            </form>
        </ul>
    </div>

    <button class="theme-toggle" id="themeToggle"><i class="fa fa-moon"></i></button>

    <div class="main-content">
        <nav class="navbar navbar-light bg-light rounded shadow-sm mb-4 px-3">
            <span class="navbar-brand">Admin Dashboard</span>

        </nav>
@if(Auth::user() && !Auth::user()->hasVerifiedEmail())
    <div class="alert alert-warning">
        Your email is not verified.
        <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Resend verification email</button>.
        </form>
    </div>
@endif

        <div class="row g-4">
            <div class="col-md-3">
                <div class="p-4 glass-card text-center">
                    <h6>Total Users</h6>
                    <div class="counter" data-target="{{ $users->count() }}">0</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 glass-card text-center">
                    <h6>Total Tasks</h6>
                    <div class="counter" data-target="{{ $tasks->count() }}">0</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 glass-card text-center">
                    <h6>Completed Tasks</h6>
                    <div class="counter" data-target="{{ $tasks->where('status','Done')->count() }}">0</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 glass-card text-center">
                    <h6>Pending Tasks</h6>
                    <div class="counter" data-target="{{ $tasks->where('status','Pending')->count() }}">0</div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 mb-4">
                <div class="p-3 glass-card">
                    <h6><i class="fa fa-user"></i> User Registration Chart</h6>
                    <canvas id="userChart" height="150"></canvas>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="p-3 glass-card">
                    <h6><i class="fa fa-tasks"></i> Task Overview</h6>
                    <canvas id="taskChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
const userCtx = document.getElementById('userChart').getContext('2d');
new Chart(userCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($userLabels ?? ['August','September','October']) !!},
        datasets: [{
            label: 'Users Registered',
            data: {!! json_encode($userData ?? [3,6,4,7]) !!},
            borderColor: '#42a5f5',
            backgroundColor: 'rgba(66,165,245,0.3)',
            fill: true,
            tension: 0.4
        }]
    }
});

const taskCtx = document.getElementById('taskChart').getContext('2d');
new Chart(taskCtx, {
    type: 'bar',
    data: {
        labels: ['Pending', 'Done', 'Finish'],
        datasets: [{
            label: 'Tasks',
            data: [
                {{ $tasks->where('status','Pending')->count() }},
                {{ $tasks->where('status','Done')->count() }},
                {{ $tasks->where('status','finish')->count() }}
            ],
            backgroundColor: ['#ffca28', '#66bb6a', '#29b6f6']
        }]
    }
});
</script>
</body>
</html>
