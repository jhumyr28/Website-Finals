<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apparel Fashion Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('css/home.css') ?>">
</head>
<body style="padding-top: 70px;">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
            <img src="<?= base_url('uploads/logo.jpg') ?>" alt="Logo" 
                 width="50" height="50" class="me-2 rounded-circle">
            <span>Apparel Fashion Boutique</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>">Home</a></li>
                
                <!-- Products Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productsDropdown" role="button" data-bs-toggle="dropdown">
                        Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productsDropdown">
                        <li><a class="dropdown-item" href="<?= base_url('products') ?>">Browse All</a></li>
                        <?php if(session()->get('user') && session()->get('user')['is_admin']): ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url('admin/products') ?>">
                                <i class="bi bi-gear me-2"></i>Manage Products
                            </a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                
                <?php if(session()->get('user')): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('cart') ?>">Cart</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('profile') ?>">
                            Hi, <?= session()->get('user')['is_admin'] ? 'Admin' : esc(session()->get('user')['name']) ?>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('logout') ?>">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('login') ?>">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('register') ?>">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('cart') ?>">Cart</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main>
