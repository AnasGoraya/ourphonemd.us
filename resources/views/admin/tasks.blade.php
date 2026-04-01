@extends('layouts.admin')

@section('title', 'Task Management')

@section('content')
<h2 class="mb-4"><i class="fa fa-tasks me-2 text-primary"></i>Task Management</h2>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-success text-white">
        <i class="fa fa-plus me-2"></i> Assign Task
    </div>
    <div class="card-body">
        <form action="{{ url('/admin/assign-task') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-3">
                <input type="text" name="title" class="form-control" placeholder="Task Title" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="description" class="form-control" placeholder="Description">
            </div>
            <div class="col-md-3">
                <select name="user_id" class="form-select" required>
                    <option value="">Select User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100"><i class="fa fa-paper-plane me-1"></i> Assign</button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-header bg-dark text-white">
        <i class="fa fa-list me-2"></i> All Tasks
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Assigned To</th>
                    <th>Status</th>
                    <th>Change</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->user->name ?? 'N/A' }}</td>
                    <td>
                        <span class="badge
                            @if($task->status == 'Done') bg-success
                            @elseif($task->status == 'finish') bg-info
                            @else bg-warning text-dark @endif">
                            {{ ucfirst($task->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ url('/admin/update-status/'.$task->id) }}" method="POST">
                            @csrf
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="Pending" {{ $task->status=='Pending'?'selected':'' }}>Pending</option>
                                <option value="Done" {{ $task->status=='Done'?'selected':'' }}>Done</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
