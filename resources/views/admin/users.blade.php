@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
    <h2 class="mb-4"><i class="fa fa-users me-2 text-primary"></i>User Management</h2>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fa fa-user-plus me-2"></i> Add New User
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Full Name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password" required>
                    @error('password')
                        <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <select name="role_id" class="form-control @error('role_id') is-invalid @enderror" required>
                        <option value="">Select Role</option>
                        <option value="5" {{ old('role_id') == '5' ? 'selected' : '' }}>Doctor</option>
                        <option value="6" {{ old('role_id') == '6' ? 'selected' : '' }}>Nurse</option>
                        <option value="3" {{ old('role_id') == '3' ? 'selected' : '' }}>Receptionist</option>
                    </select>
                    @error('role_id')
                        <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-1">
                    <button class="btn btn-success w-100"><i class="fa fa-plus"></i></button>
                </div>
            </form>

        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (isset($users) && $users->count() > 0)
        <div class="card shadow-sm border-0">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <span><i class="fa fa-list me-2"></i> All Users</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Activate/Deactivate</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ url('/admin/users/toggle-status/' . $user->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button
                                            class="btn btn-sm {{ $user->status == 'active' ? 'btn-warning' : 'btn-success' }}">
                                            {{ $user->status == 'active' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editUserModal{{ $user->id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>

                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Edit User Modal --}}
                            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                                aria-labelledby="editUserModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ url('/admin/users/update/' . $user->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title"><i class="fa fa-edit me-2"></i>Edit User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Full Name</label>
                                                    <input type="text" name="name" class="form-control"
                                                        value="{{ $user->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ $user->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Role</label>
                                                    <select name="role_id" class="form-control" required>
                                                        <option value="5" {{ $user->role_id == 5 ? 'selected' : '' }}>Doctor</option>
                                                        <option value="6" {{ $user->role_id == 6 ? 'selected' : '' }}>Nurse</option>
                                                        <option value="3" {{ $user->role_id == 3 ? 'selected' : '' }}>Receptionist</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success"><i
                                                        class="fa fa-save me-1"></i> Update</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p class="text-muted mt-3">No users found.</p>
    @endif
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Name validation for Add User form
            $('input[name="name"]').on('input', function() {
                const value = $(this).val();
                const regex = /^[a-zA-Z\s]+$/; // only letters and spaces allowed

                // Remove old error message if exists
                $(this).next('.invalid-feedback').remove();

                if (value && !regex.test(value)) {
                    $(this).after(
                        '<div class="invalid-feedback" style="display:block; color:red; font-size:12px;">Special characters and numbers are not allowed.</div>'
                        );
                    $(this).css('border', '2px solid red');
                } else {
                    $(this).css('border', '');
                }
            });

            // For Edit User modals — validate all name inputs
            $(document).on('input', 'input[name="name"]', function() {
                const value = $(this).val();
                const regex = /^[a-zA-Z\s]+$/;
                $(this).next('.invalid-feedback').remove();

                if (value && !regex.test(value)) {
                    $(this).after(
                        '<div class="invalid-feedback" style="display:block; color:red; font-size:12px;">Special characters and numbers are not allowed.</div>'
                        );
                    $(this).css('border', '2px solid red');
                } else {
                    $(this).css('border', '');
                }
            });

            // Prevent form submission if invalid name entered
            $('form').on('submit', function(e) {
                const nameField = $(this).find('input[name="name"]');
                const value = nameField.val();
                const regex = /^[a-zA-Z\s]+$/;

                if (value && !regex.test(value)) {
                    e.preventDefault();
                    nameField.next('.invalid-feedback').remove();
                    nameField.after(
                        '<div class="invalid-feedback" style="display:block; color:red; font-size:12px;">Special characters and numbers are not allowed.</div>'
                        );
                    nameField.css('border', '2px solid red');
                    nameField.focus();
                }
            });
        });
    </script>
@endsection
