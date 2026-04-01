<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
@include('error-message')


<body class="container mt-5">
    <h2>User Login</h2>
    <form action="{{ url('/login') }}" method="POST" novalidate>
        @csrf
        <div class="mb-3">
            <label>Email <span style="color: red;">*</span></label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password <span style="color: red;">*</span></label>
            <input type="password" name="password" class="form-control" required>
        </div>
        {{-- <div class="mb-3">
            <label>Select Role</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role" id="roleUser" value="1" checked>
                <label class="form-check-label" for="roleUser">User</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role" id="roleAdmin" value="2">
                <label class="form-check-label" for="roleAdmin">Admin</label>
            </div>
        </div> --}}
        <button class="btn btn-success">Login</button>
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

    $('input[required]').on('input', function() {
        updateBorder(this);
    });

    $('input[required]').on('blur', function() {
        updateBorder(this);
    });

    $('form').on('submit', function(e) {
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
