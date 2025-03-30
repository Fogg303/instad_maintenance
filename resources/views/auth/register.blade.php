<!-- filepath: c:\xampp\htdocs\instad_maintenance\resources\views\auth\register.blade.php -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Register - Beautiful Form</title>

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
                        <h3 class="text-primary font-weight-bold">Register</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="form-floating mb-3">
                                <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name') }}" required autofocus />
                                <label for="name"><i class="fas fa-user me-2"></i>Name</label>
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="form-floating mb-3">
                                <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required />
                                <label for="email"><i class="fas fa-envelope me-2"></i>Email Address</label>
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-floating mb-3">
                                <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required />
                                <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-floating mb-3">
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" required />
                                <label for="password_confirmation"><i class="fas fa-lock me-2"></i>Confirm Password</label>
                                @error('password_confirmation')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('login') }}" class="text-primary small">Already registered?</a>
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center bg-white">
                        <div class="small">
                            <a href="{{ route('login') }}" class="text-primary">Already have an account? Log in!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>