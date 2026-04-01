<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .forgot-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
        }

        .forgot-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .forgot-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
    </style>
</head>

<body>
    <div class="forgot-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card forgot-card">
                        <div class="card-header forgot-header text-center py-4">
                            <h3><i class="fas fa-key me-2"></i>Forgot Password</h3>
                        </div>

                        <div class="card-body p-4">
                            @include('error-message')

                            <form action="{{ url('/forgot-password') }}" method="POST" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Email Address <span style="color: red;">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="Enter your email" value="{{ old('email') }}" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Password <span style="color: red;">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Enter new password" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password <span style="color: red;">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Confirm new password" required>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i>Send Reset Email
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-3">
                                <p class="mb-0">Remember your password?
                                    <a href="{{ url('/login') }}" class="text-decoration-none">Login here</a>
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
