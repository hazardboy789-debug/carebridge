<div>
    <style>
        .login-container { height: 100vh; width: 100vw; position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .background-image { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-size: cover; background-position: center; z-index: 0; opacity: 0.15; }
        .login-form-overlay { background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 40px 35px; width: 100%; max-width: 420px; z-index: 1; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .user-icon-container { display: flex; justify-content: center; margin-bottom: 25px; }
        .login-btn { width: 100%; border-radius: 12px; padding: 14px; background: linear-gradient(135deg,#667eea,#764ba2); border: none; font-weight: 600; margin-bottom: 25px; }
    </style>

    <div class="login-container">
        <div class="background-image"></div>
        <div class="login-form-overlay">
            <div class="user-icon-container"><i class="bi bi-person-circle"></i></div>

            <div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <input type="email" class="form-control" wire:model="email" placeholder="Enter Email" required>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" wire:model="password" placeholder="Enter Password" required>
                </div>

                <div class="d-flex justify-content-between form-options">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password</a>
                </div>

                <button type="button" wire:click="login" class="btn btn-primary login-btn">Login</button>

                <div class="divider"><span>Or Login With</span></div>

                <div class="social-login">
                    <a href="https://www.facebook.com/webxkey" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-google"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/webxkey" class="social-icon"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>