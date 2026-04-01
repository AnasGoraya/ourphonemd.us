<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'OurPhoneMD - Telemedicine Portal')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: white !important;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 24px;
            color: #3EA293 !important;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            color: #3EA293 !important;
        }

        .nav-link {
            color: #000 !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
            border-bottom: 2px solid transparent;
            padding-bottom: 5px;
        }

        .nav-link:hover {
            color: #3EA293 !important;
            border-bottom: 2px solid #3EA293;
        }

        .nav-link.active {
            color: #3EA293 !important;
            border-bottom: 2px solid #3EA293;
        }

        .btn-outline-light {
            border: 2px solid #3EA293;
            color: #3EA293 !important;
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            background-color: #3EA293 !important;
            color: white !important;
        }

        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }

        .section {
            padding: 80px 0;
        }

        .card {
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>

    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/" style="font-size: 20px; font-weight: 600;">
                <i class="fas fa-stethoscope me-1" style="color: black; font-size: 16px;"></i>
                <span style="color: #3EA293;">OurPhone</span><span style="color: #FF3B3B;">MD</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#providerLoginModal">
                            <i class="fas fa-user-md me-1"></i>Provider
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/patient/signin">
                            <i class="fas fa-sign-in-alt me-1"></i>Sign In
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-2" href="{{ route('signup.terms') }}">
                            <i class="fas fa-user-plus me-1"></i>Sign Up
                        </a>
                    </li>
                    @auth('patient')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::guard('patient')->user()->first_name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('patient.appointment.dashboard') }}">
                                        <i class="fas fa-calendar-alt me-1"></i>Appointments
                                    </a>
                                </li>
                                <li><a class="dropdown-item" href="/patient/profile">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('patient.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <div class="modal fade" id="providerLoginModal" tabindex="-1" aria-labelledby="providerLoginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="providerLoginModalLabel">Provider Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card border-0 shadow">
                        <div class="card-body p-4">
                            <form action="{{ route('provider.login') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="provider_email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="provider_email" name="email"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="provider_password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="provider_password"
                                        name="password" required>
                                </div>

                                <button type="submit" class="btn w-100"
                                    style="background-color: #3EA293; color: white;">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
