=<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Registration</h2>


@foreach ($errors->all() as $message)
        <div class="alert alert-danger">{{ $message }}</div>
@endforeach
    <form action="{{ url('/user/register') }}" method="POST" novalidate>
        @csrf
        <div class="mb-3">
            <label>Name <span style="color: red;">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
            <div class="invalid-feedback" style="display: none; font-size: 12px;">No special characters or numbers allowed.</div>

        </div>
        <div class="mb-3">
            <label>Email <span style="color: red;">*</span></label>
            <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror" required>

        </div>
        <div class="mb-3">
            <label>Username <span style="color: red;">*</span></label>
            <select name="username" class="form-control @error('username') is-invalid @enderror" required>
                <option value="">Select Username</option>
                <option value="user1">user1</option>
                <option value="user2">user2</option>
                <option value="user3">user3</option>
            </select>
            @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Password <span style="color: red;">*</span></label>
            <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" required>

        </div>
        <div class="mb-3">
            <label>Select Role <span style="color: red;">*</span></label>
        <button class="btn btn-primary">Register</button><br>
          <p>If already have account then <a href="{{ url('/login') }}" class="btn btn-link">click here</a></p>
    </form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
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
