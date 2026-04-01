{{-- <!DOCTYPE html>
<html>
<head>
    <title>Admin Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <h2>Admin Register</h2>
    <form action="{{ url('/admin/register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name <span style="color: red;">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
            <div class="invalid-feedback" style="display: none; font-size: 12px;">No special characters or numbers allowed.</div>
            @error('name')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" required>
            @error('email')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
        </div>
        <button class="btn btn-primary">Register</button>
           <p>if already have account then<a href="{{ url('/admin/login') }}">  click here</a></p>
    </form>
</body>
</html> --}}

<!DOCTYPE html>
<html>
<head>
    <title>Admin Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .is-invalid {
            box-shadow: 0 0 5px rgba(255, 0, 0, 0.4);
        }
        .error-text {
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="container mt-5">

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<h2>Admin Register</h2>
<form action="{{ url('/admin/register') }}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label>Name <span style="color: red;">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
        <div class="invalid-feedback" style="display: none; font-size: 12px;">No special characters or numbers allowed.</div>
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label>Email <span style="color: red;">*</span></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
        @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

        <label>Password <span style="color: red;">*</span></label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
        @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <button class="btn btn-primary">Register</button>
    <p>if already have account then <a href="{{ url('/admin/login') }}">click herew</a></p>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    $('input[required]').css('border', '2px solid red !important');

    function updateBorder(field) {
        if ($(field).val().trim() === '') {
            $(field).css('border', '2px solid red !important');
        } else {
            $(field).css('border', '');
        }
    }

    $('input[name="name"]').on('input', function() {
        const value = $(this).val();
        const regex = /^[a-zA-Z\s]*$/;
        if (!regex.test(value)) {
            $(this).next('.invalid-feedback').show();
            $(this).css('border', '2px solid red !important');
        } else {
            $(this).next('.invalid-feedback').hide();
            updateBorder(this);
        }
    });

    $('input[required]').on('input', function() {
        updateBorder(this);
    });

    $('input[required]').on('blur', function() {
        updateBorder(this);
    });

    $('form').on('submit', function(e) {
        const nameField = $('input[name="name"]');
        const nameValue = nameField.val();
        const regex = /^[a-zA-Z\s]*$/;
        if (!regex.test(nameValue)) {
            e.preventDefault();
            nameField.next('.invalid-feedback').show();
            nameField.css('border', '2px solid red !important');
            nameField.focus();
            return;
        }

        let firstEmpty = null;
        $('input[required]').each(function() {
            if ($(this).val().trim() === '') {
                $(this).css('border', '2px solid red !important');
                if (!firstEmpty) firstEmpty = this;
            }
        });
        if (firstEmpty) {
            e.preventDefault();
            $('.required-error').remove();
            $(firstEmpty).closest('.mb-3').prepend('<div class="required-error text-danger" style="font-size: 12px;">Required</div>');
            firstEmpty.focus();
        }
    });
});
</script>
</body>
</html>
