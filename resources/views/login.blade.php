<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
        }

        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card login-card">
                        <div class="card-header login-header text-center py-4">
                            <h3><i class="fas fa-sign-in-alt me-2"></i>Login</h3>
                        </div>

                        <div class="card-body p-4">
                            @if (session('verify_notice'))
                                <div class="alert alert-info text-center">
                                    📩 Registration successful! Please check your email to verify your account before
                                    logging in.
                                </div>
                            @else
                                @include('error-message')
                                @if (session('status'))
                                    <div class="alert alert-success text-center">
                                        {{ session('status') }}
                                    </div>
                                @endif


                                <form action="{{ url('/login') }}" method="POST" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Email Address <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Enter your email" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Enter your password" required>
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-sign-in-alt me-2"></i> Login
                                        </button>
                                    </div>
                                </form>
                            @endif

                            <div class="text-center mt-3">
                                <p class="mb-0">Don't have an account?
                                    <a href="{{ url('/register') }}" class="text-decoration-none">Register here</a>
                                </p>
                                <p class="mb-0">
                                    <p><a href="{{ url('/forgot-password') }}" class="text-decoration-none">Forgot Password?</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
