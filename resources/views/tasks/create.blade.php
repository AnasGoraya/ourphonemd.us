<!DOCTYPE html>
<html>
<head>
    <title>Create Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2>Add New Task</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form action="{{ url('/task/store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>

    <input type="hidden" name="user_id" value="{{ Auth::id() }}">

    <button type="submit" class="btn btn-success">Save Task</button>
    <a href="{{ url('/user/dashboard') }}" class="btn btn-secondary">Back</a>
</form>

</body>
</html>
