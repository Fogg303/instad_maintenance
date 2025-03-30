<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Welcome - Maintenance Platform</title>

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
                color: #fff;
            }
            .hero {
                background: linear-gradient(to right, rgba(78, 84, 200, 0.8), rgba(143, 148, 251, 0.8)), url('https://source.unsplash.com/1600x900/?technology,maintenance');
                background-size: cover;
                background-position: center;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                color: #fff;
            }
            .hero h1 {
                font-size: 3rem;
                font-weight: bold;
            }
            .hero p {
                font-size: 1.25rem;
                margin-top: 1rem;
            }
            .btn-primary {
                background-color: #6c63ff;
                border-color: #6c63ff;
            }
            .btn-primary:hover {
                background-color: #574bff;
                border-color: #574bff;
            }
            .features {
                padding: 4rem 0;
            }
            .feature-card {
                background: #fff;
                border-radius: 15px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 2rem;
                text-align: center;
                transition: transform 0.3s ease;
            }
            .feature-card:hover {
                transform: translateY(-10px);
            }
            .feature-card i {
                font-size: 3rem;
                color: #6c63ff;
            }
            .footer {
                background: #2c2c54;
                color: #fff;
                padding: 2rem 0;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <!-- Hero Section -->
        <div class="hero">
            <div>
                <h1>Welcome to the Maintenance Platform</h1>
                <p>Effortlessly manage and maintain your IT equipment with our powerful tools.</p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-4">Get Started</a>
            </div>
        </div>

        <!-- Features Section -->
        <div class="features container text-center">
            <h2 class="mb-5">Why Choose Us?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-tools"></i>
                        <h4 class="mt-3">Comprehensive Tools</h4>
                        <p>Access a wide range of tools to streamline your maintenance processes.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-shield-alt"></i>
                        <h4 class="mt-3">Secure Platform</h4>
                        <p>Keep your data safe with our state-of-the-art security measures.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-chart-line"></i>
                        <h4 class="mt-3">Real-Time Analytics</h4>
                        <p>Monitor your equipment's performance with real-time insights.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action Section -->
        <div class="text-center py-5 bg-light">
            <h2>Ready to Simplify Your Maintenance?</h2>
            <p class="mt-3">Join thousands of users who trust our platform for their IT maintenance needs.</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg mt-3">Sign Up Now</a>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; 2025 Maintenance Platform. All rights reserved.</p>
            <p>
                <a href="#" class="text-white me-3">Privacy Policy</a>
                <a href="#" class="text-white">Terms of Service</a>
            </p>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>