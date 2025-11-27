<section class="login-section d-flex align-items-center justify-content-center" style="min-height: 80vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="login-icon mb-3">
                                <i class="bi bi-person-circle" style="font-size: 3rem; color: #667eea;"></i>
                            </div>
                            <h2 class="fw-bold mb-1">Hello, User!</h2>
                            <p class="text-muted">Sign in to your account</p>
                        </div>

                        <!-- Error Alert -->
                        <?php if(session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                <?= esc(session()->getFlashdata('error')) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Success Alert -->
                        <?php if(session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                <?= esc(session()->getFlashdata('success')) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Form -->
                        <form action="<?= base_url('login') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Email Field -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope" style="color: #667eea;"></i>
                                    </span>
                                    <input type="email" name="email" value="<?= esc(old('email')) ?>" 
                                           class="form-control border-start-0 ps-0" 
                                           placeholder="your@email.com" required>
                                </div>
                                <?php if(isset($errors['email'])): ?>
                                    <small class="text-danger d-block mt-1">
                                        <i class="bi bi-exclamation-circle me-1"></i><?= esc($errors['email']) ?>
                                    </small>
                                <?php endif; ?>
                            </div>

                            <!-- Password Field -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock" style="color: #667eea;"></i>
                                    </span>
                                    <input type="password" name="password" 
                                           class="form-control border-start-0 ps-0" 
                                           placeholder="Enter your password" required>
                                </div>
                                <?php if(isset($errors['password'])): ?>
                                    <small class="text-danger d-block mt-1">
                                        <i class="bi bi-exclamation-circle me-1"></i><?= esc($errors['password']) ?>
                                    </small>
                                <?php endif; ?>
                            </div>

                            <!-- Remember & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                                <a href="#" class="text-decoration-none small">Forgot password?</a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold" 
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                            </button>
                        </form>

                        <!-- Divider -->
                        <div class="d-flex align-items-center my-4">
                            <hr class="flex-grow-1">
                            <span class="px-3 text-muted small">New to Apparel?</span>
                            <hr class="flex-grow-1">
                        </div>

                        <!-- Register Link -->
                        <div class="text-center">
                            <p class="mb-0">Don't have an account? 
                                <a href="<?= base_url('register') ?>" class="fw-semibold text-primary text-decoration-none">
                                    Create one now <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </p>
                        </div>

                        <!-- Demo Credentials (for testing) -->
                        <div class="alert alert-info mt-4 mb-0">
                            <small><strong>Test Account:</strong></small><br>
                            <small>Email: admin@example.com</small><br>
                            <small>Password: password123</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.login-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.login-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2) !important;
}

.input-group-text {
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.input-group:focus-within .input-group-text {
    border-color: #667eea;
    background-color: #f8f9ff !important;
}

.form-control {
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
}
</style>
