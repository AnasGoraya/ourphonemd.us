
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .task-card {
            border-left: 4px solid #007bff;
            transition: transform 0.2s;
        }
        .task-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-user-circle me-2"></i>Welcome  {{ Auth::user()->name }}</h1>
                    <p class="lead mb-0">Task Management Dashboard</p>
                </div>
                <div class="col-md-4 text-end">
                    <form action="{{ route('user.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ $tasks->where('status', 'Pending')->count() }}</h4>
                                <p>Pending Tasks</p>
                            </div>
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ $tasks->where('status', 'Done')->count() }}</h4>
                                <p>Completed Tasks</p>
                            </div>
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ $tasks->where('status', 'finish')->count() }}</h4>
                                <p>Finished Tasks</p>
                            </div>
                            <i class="fas fa-flag-checkered fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ $tasks->count() }}</h4>
                                <p>Total Tasks</p>
                            </div>
                            <i class="fas fa-tasks fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card shadow">
            {{-- <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-tasks me-2"></i>Your Tasks</h4>
                <a href="{{ url('/task/create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus me-1"></i> Add New Task
                </a>
            </div> --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Assigned By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td><strong>{{ $task->title }}</strong></td>
                                <td>{{ Str::limit($task->description, 50) }}</td>
                                <td>
                                    <span class="badge
                                        @if($task->status == 'Done') bg-success
                                        @elseif($task->status == 'finish') bg-info
                                        @else bg-warning @endif">
                                        {{ $task->status }}
                                    </span>
                                </td>
                                <td>
                                    @if($task->assigned_by)
                                        <span class="text-primary">{{ App\Models\Admin::find($task->assigned_by)->name }}</span>
                                    {{-- @else
                                        <span class="text-success">Self Created</span> --}}
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('task.comment', $task->id) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-comments"></i>
                                        </a>
                                        @if($task->status != 'Done')
                                            <form method="POST" action="{{ url('/task/update/'.$task->id) }}" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Done">
                                                <button type="submit" class="btn btn-outline-success">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
