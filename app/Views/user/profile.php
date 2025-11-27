<section class="py-5" style="background: #f8f9fa; min-height: calc(100vh - 70px);">
    <div class="container">
        <!-- Page Header -->
        <div class="mb-5">
            <h1 class="display-5 fw-bold mb-2">
                <i class="bi bi-person-circle me-2"></i>My Profile
            </h1>
            <p class="text-muted">Manage your account information and security settings</p>
        </div>

        <!-- Messages -->
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <strong>Success!</strong> <?= esc(session()->getFlashdata('success')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Error!</strong> <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Profile Info Card -->
            <div class="col-lg-8">
                <!-- User Info Section -->
                <div class="card shadow-lg border-0 rounded-lg mb-4 overflow-hidden">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem;">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>Account Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?= base_url('profile/update') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Name Field -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person me-2"></i>Full Name
                                </label>
                                <input type="text" name="name" value="<?= esc($user['name']) ?>" 
                                       class="form-control form-control-lg" required>
                                <?php if(session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['name'])): ?>
                                    <small class="text-danger d-block mt-2">
                                        <i class="bi bi-exclamation-circle me-1"></i><?= session()->getFlashdata('errors')['name'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>

                            <!-- Email Field -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-2"></i>Email Address
                                </label>
                                <input type="email" name="email" value="<?= esc($user['email']) ?>" 
                                       class="form-control form-control-lg" required>
                                <?php if(session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['email'])): ?>
                                    <small class="text-danger d-block mt-2">
                                        <i class="bi bi-exclamation-circle me-1"></i><?= session()->getFlashdata('errors')['email'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>

                            <!-- Account Type -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-shield-check me-2"></i>Account Type
                                </label>
                                <div class="p-3 bg-light rounded-lg">
                                    <span class="badge <?= $user['is_admin'] ? 'bg-danger' : 'bg-info' ?>" style="font-size: 1rem;">
                                        <i class="bi <?= $user['is_admin'] ? 'bi-star-fill' : 'bi-person-fill' ?> me-1"></i>
                                        <?= $user['is_admin'] ? 'Administrator' : 'Customer' ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2 pt-3 border-top">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle me-2"></i>Save Changes
                                </button>
                                <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Back
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password Section -->
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                    <div class="card-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 1.5rem;">
                        <h5 class="mb-0">
                            <i class="bi bi-lock me-2"></i>Change Password
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?= base_url('profile/change-password') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Current Password -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-lock-fill me-2"></i>Current Password
                                </label>
                                <input type="password" name="current_password" 
                                       class="form-control form-control-lg" required>
                                <?php if(session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['current_password'])): ?>
                                    <small class="text-danger d-block mt-2">
                                        <i class="bi bi-exclamation-circle me-1"></i><?= session()->getFlashdata('errors')['current_password'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>

                            <!-- New Password -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-key me-2"></i>New Password
                                </label>
                                <input type="password" name="new_password" 
                                       class="form-control form-control-lg" required minlength="6">
                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-info-circle me-1"></i>Minimum 6 characters
                                </small>
                                <?php if(session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['new_password'])): ?>
                                    <small class="text-danger d-block mt-2">
                                        <i class="bi bi-exclamation-circle me-1"></i><?= session()->getFlashdata('errors')['new_password'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-check-circle me-2"></i>Confirm Password
                                </label>
                                <input type="password" name="confirm_password" 
                                       class="form-control form-control-lg" required>
                                <?php if(session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['confirm_password'])): ?>
                                    <small class="text-danger d-block mt-2">
                                        <i class="bi bi-exclamation-circle me-1"></i><?= session()->getFlashdata('errors')['confirm_password'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2 pt-3 border-top">
                                <button type="submit" class="btn btn-danger btn-lg">
                                    <i class="bi bi-shield-lock me-2"></i>Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Profile Summary Card -->
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden mb-4">
                    <div class="card-body text-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <i class="bi bi-person-circle" style="font-size: 4rem;"></i>
                        <h4 class="fw-bold mt-3"><?= esc($user['name']) ?></h4>
                        <p class="mb-0 opacity-75"><?= esc($user['email']) ?></p>
                    </div>
                </div>

                <!-- Account Stats -->
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-info-circle me-2"></i>Account Details
                        </h6>
                        
                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block">Account Status</small>
                            <strong>
                                <span class="badge <?= $user['is_admin'] ? 'bg-danger' : 'bg-success' ?>">
                                    <?= $user['is_admin'] ? 'Administrator' : 'Active' ?>
                                </span>
                            </strong>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block">Email Verified</small>
                            <strong>
                                <i class="bi bi-check-circle text-success me-1"></i>Yes
                            </strong>
                        </div>

                        <div>
                            <small class="text-muted d-block">Member Since</small>
                            <strong>
                                <i class="bi bi-calendar me-1"></i>
                                <?= date('F Y', strtotime($user['created_at'] ?? date('Y-m-d'))) ?>
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .form-control, .form-control-lg {
        border-radius: 10px;
        border: 1px solid #dee2e6;
        transition: all 0.3s;
    }

    .form-control:focus, .form-control-lg:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .card {
        border-radius: 15px;
        transition: all 0.3s;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
