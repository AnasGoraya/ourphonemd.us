<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - 404</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .error-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .error-icon {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="error-card p-5 text-center">
                    <div class="error-icon mb-4">
                        <i class="fas fa-exclamation-triangle text-primary display-1"></i>
                    </div>
                    <h1 class="display-4 fw-bold text-primary mb-3">404</h1>
                    <h2 class="mb-3">Page Not Found</h2>
                    <p class="text-muted mb-4">The page you're looking for doesn't exist.</p>

                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                        <a href="{{ url('/') }}" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-home me-2"></i>Go Home
                        </a>
                        <button onclick="history.back()" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="fas fa-arrow-left me-2"></i>Go Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
