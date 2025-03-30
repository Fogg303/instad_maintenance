<!-- filepath: c:\xampp\htdocs\instad_maintenance\resources\views\auth\forgot-password.blade.php -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Forgot Password - Beautiful Form</title>

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Font Awesome -->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

        <!-- Custom Styles -->
        <style>
            body {
                background: linear-gradient(to right, #4e54c8, #8f94fb);
                font-family: 'Figtree', sans-serif;
            }
            .card {
                border-radius: 15px;
            }
            .form-control:focus {
                border-color: #6c63ff;
                box-shadow: 0 0 5px rgba(108, 99, 255, 0.5);
            }
            .btn-primary {
                background-color: #6c63ff;
                border-color: #6c63ff;
            }
            .btn-primary:hover {
                background-color: #574bff;
                border-color: #574bff;
            }
        </style>
    </head>
    <body>
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-white text-center">
                        <h3 class="text-primary font-weight-bold">Forgot Password</h3>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success text-center">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="form-floating mb-3">
                                <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autofocus />
                                <label for="email"><i class="fas fa-envelope me-2"></i>Email Address</label>
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('login') }}" class="text-primary small">Back to Login</a>
                                <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center bg-white">
                        <div class="small">
                            <a href="{{ route('register') }}" class="text-primary">Need an account? Sign up!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>