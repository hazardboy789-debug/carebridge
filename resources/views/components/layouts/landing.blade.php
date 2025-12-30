<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index - CareBridge</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="/assets/css/main.css" rel="stylesheet">

    <!-- Custom Registration Modal Styles -->
    <style>
        .register-modal-content {
            background: #fff;
            border-radius: 0;
        }

        .register-header {
            background: linear-gradient(135deg, #3fbbc0 0%, #2c9ca1 100%);
            padding: 30px;
            border-radius: 0;
        }

        .register-header h2 {
            color: #fff;
            font-size: 28px;
            font-weight: 600;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .register-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin: 8px 0 0;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #2c4964;
            font-size: 14px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
        }

        .form-label i {
            margin-right: 6px;
            color: #3fbbc0;
        }

        .form-control-custom {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e8f1f2;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
            box-sizing: border-box;
            outline: none;
            background: #fff;
            color: #2c4964;
            font-family: 'Roboto', sans-serif;
        }

        .form-control-custom:focus {
            border-color: #3fbbc0;
            box-shadow: 0 0 0 3px rgba(63, 187, 192, 0.1);
        }

        .form-control-custom::placeholder {
            color: #a6b8c0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group-full {
            margin-bottom: 20px;
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #3fbbc0 0%, #2c9ca1 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(63, 187, 192, 0.3);
            font-family: 'Poppins', sans-serif;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(63, 187, 192, 0.4);
            background: linear-gradient(135deg, #2c9ca1 0%, #3fbbc0 100%);
        }

        .alert-success {
            padding: 12px 16px;
            background: #d4edda;
            border-left: 4px solid #28a745;
            border-radius: 8px;
            margin-bottom: 20px;
            color: #155724;
            font-size: 14px;
        }

        .alert-error {
            padding: 12px 16px;
            background: #f8d7da;
            border-left: 4px solid #dc3545;
            border-radius: 8px;
            margin-bottom: 20px;
            color: #721c24;
            font-size: 14px;
        }

        .error-text {
            color: #dc3545;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
            font-size: 14px;
        }

        .login-link a {
            color: #3fbbc0;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Modal customization */
        #registerModal .modal-content {
            border: none;
            border-radius: 0;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        #registerModal .modal-header {
            border: none;
            padding: 0;
            position: relative;
        }

        #registerModal .modal-body {
            padding: 0;
        }

        #registerModal .btn-close {
            position: absolute;
            right: 20px;
            top: 20px;
            z-index: 10;
            background: rgba(255, 255, 255, 0.3);
            opacity: 1;
            border-radius: 50%;
            padding: 10px;
            width: 35px;
            height: 35px;
        }

        #registerModal .btn-close:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .register-header h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.webp" alt=""> -->
                <h1 class="sitename">Care<span>Bridge</span></h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('welcome') }}" class="active">Home</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('services') }}">Services</a></li>
                    <li><a href="{{ route('doctors') }}">Doctors</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <div>
                @if(Auth::check())
                <a class="btn-getstarted" href="{{ route('patient.dashboard') }}">Go to dashboard</a>
                @else
                <button type="button" class="btn-getstarted me-2" data-bs-toggle="modal"
                    data-bs-target="#registerModal">Register</button>
                <a href="{{ route('login') }}" class="btn-getstarted">Login</a>
                @endif
            </div>


        </div>
    </header>

    <main class="main">
        {{ $slot }}

        <!-- Registration Modal -->
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Registration Form Content -->
                        <div class="register-modal-content">
                            <!-- Header -->
                            <div class="register-header">
                                <h2><i class="bi bi-person-plus-fill"></i> Create Your Account</h2>
                                <p>Join CareBridge today and experience quality healthcare</p>
                            </div>

                            <!-- Form Content -->
                            <div style="padding: 30px;">

                                <!-- Success Message -->
                                <div id="successMessage" class="alert-success" style="display: none;">
                                    <i class="bi bi-check-circle-fill"></i> <span id="successText"></span>
                                </div>

                                <!-- Error Message -->
                                <div id="errorMessage" class="alert-error" style="display: none;">
                                    <i class="bi bi-exclamation-triangle-fill"></i> <span id="errorText"></span>
                                </div>

                                <form id="registerForm" method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <!-- Name and Email -->
                                    <div class="form-grid">
                                        <div>
                                            <label class="form-label">
                                                <i class="bi bi-person"></i> Your Name
                                            </label>
                                            <input type="text" name="name" id="name" class="form-control-custom"
                                                placeholder="John Doe" required>
                                            <span class="error-text" id="error-name"></span>
                                        </div>
                                        <div>
                                            <label class="form-label">
                                                <i class="bi bi-envelope"></i> Email Address
                                            </label>
                                            <input type="email" name="email" id="email" class="form-control-custom"
                                                placeholder="john@example.com" required>
                                            <span class="error-text" id="error-email"></span>
                                        </div>
                                    </div>

                                    <!-- Contact and Password -->
                                    <div class="form-grid">
                                        <div>
                                            <label class="form-label">
                                                <i class="bi bi-telephone"></i> Contact Number
                                            </label>
                                            <input type="text" name="contact" id="contact" class="form-control-custom"
                                                placeholder="+1234567890" required>
                                            <span class="error-text" id="error-contact"></span>
                                        </div>
                                        <div>
                                            <label class="form-label">
                                                <i class="bi bi-lock"></i> Password
                                            </label>
                                            <input type="password" name="password" id="password"
                                                class="form-control-custom" placeholder="••••••••" required>
                                            <span class="error-text" id="error-password"></span>
                                        </div>
                                    </div>

                                    <!-- Confirm Password and DOB -->
                                    <div class="form-grid">
                                        <div>
                                            <label class="form-label">
                                                <i class="bi bi-lock-fill"></i> Confirm Password
                                            </label>
                                            <input type="password" name="password_confirmation"
                                                id="password_confirmation" class="form-control-custom"
                                                placeholder="••••••••" required>
                                            <span class="error-text" id="error-password_confirmation"></span>
                                        </div>
                                        <div>
                                            <label class="form-label">
                                                <i class="bi bi-calendar-event"></i> Date of Birth
                                            </label>
                                            <input type="date" name="dob" id="dob" class="form-control-custom">
                                            <span class="error-text" id="error-dob"></span>
                                        </div>
                                    </div>

                                    <!-- Age and Gender -->
                                    <div class="form-grid">
                                        <div>
                                            <label class="form-label">
                                                <i class="bi bi-123"></i> Age
                                            </label>
                                            <input type="number" name="age" id="age" class="form-control-custom"
                                                placeholder="25" min="0">
                                            <span class="error-text" id="error-age"></span>
                                        </div>
                                        <div>
                                            <label class="form-label">
                                                <i class="bi bi-gender-ambiguous"></i> Gender
                                            </label>
                                            <select name="gender" id="gender" class="form-control-custom">
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                            <span class="error-text" id="error-gender"></span>
                                        </div>
                                    </div>

                                    <!-- Address -->
                                    <div class="form-group-full">
                                        <label class="form-label">
                                            <i class="bi bi-geo-alt"></i> Address
                                        </label>
                                        <input type="text" name="address" id="address" class="form-control-custom"
                                            placeholder="123 Main Street, City">
                                        <span class="error-text" id="error-address"></span>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group-full">
                                        <label class="form-label">
                                            <i class="bi bi-card-text"></i> Short Description <span
                                                style="color: #999; font-weight: 400;">(optional)</span>
                                        </label>
                                        <textarea name="description" id="description" rows="3"
                                            class="form-control-custom" placeholder="Tell us a bit about yourself..."
                                            style="resize: vertical;"></textarea>
                                        <span class="error-text" id="error-description"></span>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn-register">
                                        <i class="bi bi-check-circle"></i> Create Account
                                    </button>

                                    <!-- Login Link -->
                                    <div class="login-link">
                                        Already have an account? <a href="#" data-bs-dismiss="modal">Sign In</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- End Registration Form Content -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Registration Modal -->
    </main>

    <footer id="footer" class="footer position-relative">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">CareBridge</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>123 Street</p>
                        <p>Gampaha Hospital</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>075 581 1351</span></p>
                        <p><strong>Email:</strong> <span>consultation@carebridge.lk</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Terms of service</a></li>
                        <li><a href="#">Privacy policy</a></li>
                    </ul>
                </div>


            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

    <!-- Registration Modal Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const registerForm = document.getElementById('registerForm');
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');
            const successText = document.getElementById('successText');
            const errorText = document.getElementById('errorText');
            const registerModal = document.getElementById('registerModal');

            // Clear all error messages
            function clearErrors() {
                document.querySelectorAll('.error-text').forEach(el => {
                    el.textContent = '';
                    el.style.display = 'none';
                });
                document.querySelectorAll('.form-control-custom').forEach(el => {
                    el.style.borderColor = '#e8f1f2';
                });
                successMessage.style.display = 'none';
                errorMessage.style.display = 'none';
            }

            // Display field-specific errors
            function showFieldErrors(errors) {
                Object.keys(errors).forEach(field => {
                    const errorElement = document.getElementById('error-' + field);
                    const inputElement = document.getElementById(field);
                    
                    if (errorElement && errors[field][0]) {
                        errorElement.textContent = errors[field][0];
                        errorElement.style.display = 'block';
                    }
                    
                    if (inputElement) {
                        inputElement.style.borderColor = '#dc3545';
                    }
                });
            }

            // Handle form submission
            registerForm.addEventListener('submit', function(e) {
                e.preventDefault();
                clearErrors();

                const formData = new FormData(registerForm);
                const submitButton = registerForm.querySelector('.btn-register');
                const originalText = submitButton.innerHTML;
                
                // Disable submit button and show loading state
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Creating Account...';

                fetch('{{ route('register') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        successText.textContent = data.message;
                        successMessage.style.display = 'block';
                        
                        // Reset form
                        registerForm.reset();
                        
                        // Redirect after short delay
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1500);
                    } else {
                        // Show error message
                        errorText.textContent = data.message || 'Registration failed. Please try again.';
                        errorMessage.style.display = 'block';
                        
                        // Show field-specific errors if available
                        if (data.errors) {
                            showFieldErrors(data.errors);
                        }
                        
                        // Re-enable submit button
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorText.textContent = 'An unexpected error occurred. Please try again.';
                    errorMessage.style.display = 'block';
                    
                    // Re-enable submit button
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                });
            });

            // Clear errors when modal is opened
            registerModal.addEventListener('show.bs.modal', function () {
                clearErrors();
                registerForm.reset();
            });
        });
    </script>

</body>

</html>