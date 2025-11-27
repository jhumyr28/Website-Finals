<section class="register-section d-flex align-items-center justify-content-center" style="min-height: 80vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="register-card card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="register-icon mb-3">
                                <i class="bi bi-person-plus-circle" style="font-size: 3rem; color: #667eea;"></i>
                            </div>
                            <h2 class="fw-bold mb-1">Create Account</h2>
                            <p class="text-muted">Join our fashion community today</p>
                        </div>

                        <!-- Error Alert -->
                        <?php if(session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                <strong>Please fix the following:</strong>
                                <?php foreach(session()->getFlashdata('errors') as $e): ?>
                                    <div><i class="bi bi-dash me-2"></i><?= esc($e) ?></div>
                                <?php endforeach; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Form -->
                        <form action="<?= base_url('register') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Name Field -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person" style="color: #667eea;"></i>
                                    </span>
                                    <input type="text" name="name" value="<?= esc(old('name')) ?>" 
                                           class="form-control border-start-0 ps-0" 
                                           placeholder="John Doe" required>
                                </div>
                            </div>

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
                                           placeholder="At least 6 characters" required>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    <i class="bi bi-info-circle me-1"></i>Must be at least 6 characters long
                                </small>
                            </div>

                            <!-- Terms Checkbox -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                <label class="form-check-label" for="agreeTerms">
                                    I agree to the <a href="#" class="text-primary text-decoration-none">Terms & Conditions</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold" 
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                <i class="bi bi-person-check me-2"></i>Create Account
                            </button>
                        </form>

                        <!-- Divider -->
                        <div class="d-flex align-items-center my-4">
                            <hr class="flex-grow-1">
                            <span class="px-3 text-muted small">Already registered?</span>
                            <hr class="flex-grow-1">
                        </div>

                        <!-- Login Link -->
                        <div class="text-center">
                            <p class="mb-0">Already have an account? 
                                <a href="<?= base_url('login') ?>" class="fw-semibold text-primary text-decoration-none">
                                    Sign in <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.register-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.register-card:hover {
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

.form-check-input {
    border: 1px solid #dee2e6;
}

.form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}
</style>
