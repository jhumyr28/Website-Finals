<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('css/home.css') ?>">
</head>
<body>
    <!-- Main Navbar (matching home.php) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
                <img src="<?= base_url('uploads/logo.jpg') ?>" alt="Logo" 
                     width="50" height="50" class="me-2 rounded-circle">
                <span>Admin Dashboard</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url('admin/products') ?>"><i class="bi bi-collection me-1"></i>Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>"><i class="bi bi-house me-1"></i>Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-1"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header Section with Gradient -->
    <section class="head-admin">
        <div class="container">
            <h1 class="display-5 fw-bold">Manage Products</h1>
            <p class="lead">Add, edit, and manage your store products</p>
        </div>
    </section>

    <section class="container py-5" style="background: #f8f9fa; min-height: calc(100vh - 70px);">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        <strong>Success!</strong> <?= esc(session()->getFlashdata('success')) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Add Product Button -->
                <div class="mb-4">
                    <button class="btn btn-primary btn-lg" data-bs-toggle="collapse" data-bs-target="#addProductForm">
                        <i class="bi bi-plus-circle me-2"></i>Add New Product
                    </button>
                </div>

                <!-- Add Product Form -->
                <div class="collapse mb-4" id="addProductForm">
                    <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                        <div class="card-header" style="background: linear-gradient(to right, #007bff, #00bcd4); color: white; padding: 1.5rem;">
                            <h5 class="mb-0">
                                <i class="bi bi-plus-circle me-2"></i>Add New Product
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="<?= base_url('admin/products/store') ?>" method="post" enctype="multipart/form-data">
                                <?= csrf_field() ?>

                                <!-- Error Messages -->
                                <?php if(session()->getFlashdata('errors')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        <strong>Please fix the following errors:</strong>
                                        <?php foreach(session()->getFlashdata('errors') as $e): ?>
                                            <div class="ms-3 mt-2"><i class="bi bi-dash me-2"></i><?= esc($e) ?></div>
                                        <?php endforeach; ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                <?php endif; ?>

                                <div class="row">
                                    <!-- Product Name -->
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-tag me-2"></i>Product Name
                                        </label>
                                        <input type="text" name="name" value="<?= esc(old('name')) ?>" 
                                               class="form-control form-control-lg" 
                                               placeholder="e.g., White T-Shirt" required>
                                        <small class="text-muted d-block mt-1">
                                            <i class="bi bi-info-circle me-1"></i>URL slug will be auto-generated
                                        </small>
                                    </div>

                                    <!-- Price and Stock Row -->
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-currency-dollar me-2"></i>Price (₱)
                                        </label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light">₱</span>
                                            <input type="number" name="price" value="<?= esc(old('price')) ?>" 
                                                   class="form-control" placeholder="0.00" step="0.01" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-box2 me-2"></i>Stock Quantity
                                        </label>
                                        <input type="number" name="stock" value="<?= esc(old('stock')) ?>" 
                                               class="form-control form-control-lg" placeholder="0" required>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-12 mb-4">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-file-text me-2"></i>Description
                                        </label>
                                        <textarea name="description" class="form-control" rows="4" 
                                                  placeholder="Write a detailed product description..."><?= esc(old('description')) ?></textarea>
                                    </div>

                                    <!-- Image Upload -->
                                    <div class="col-12 mb-4">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-image me-2"></i>Product Image
                                        </label>
                                        <div class="border-2 border-dashed rounded-3 p-4 text-center" id="imageDropZone" style="cursor: pointer; transition: all 0.3s;">
                                            <input type="file" name="image" id="imageInput" class="form-control d-none" accept="image/*">
                                            <i class="bi bi-cloud-upload text-muted" style="font-size: 2rem;"></i>
                                            <p class="mb-0 mt-2">
                                                <strong>Click to upload</strong> or drag and drop
                                            </p>
                                            <small class="text-muted">JPG, PNG, GIF (max 5MB)</small>
                                        </div>
                                    </div>

                                    <!-- Featured Checkbox -->
                                    <div class="col-12 mb-4">
                                        <div class="form-check form-switch p-3 bg-light rounded-lg">
                                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured">
                                            <label class="form-check-label fw-semibold" for="isFeatured">
                                                <i class="bi bi-star-fill me-2 text-warning"></i>Mark as Featured Product
                                            </label>
                                            <small class="d-block text-muted mt-2">Featured products will be displayed on the homepage</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="d-flex gap-2 pt-3 border-top">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="bi bi-check-circle me-2"></i>Add Product
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i>Clear
                                    </button>
                                    <button type="button" class="btn btn-outline-danger ms-auto" data-bs-toggle="collapse" data-bs-target="#addProductForm">
                                        <i class="bi bi-x-circle me-1"></i>Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem;">
                        <h5 class="mb-0">
                            <i class="bi bi-list me-2"></i>Products List
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($products) > 0): ?>
                                    <?php foreach($products as $p): ?>
                                        <tr>
                                            <td><small class="text-muted">#<?= esc($p['id']) ?></small></td>
                                            <td><strong><?= esc($p['name']) ?></strong></td>
                                            <td><span class="badge bg-success">₱<?= esc(number_format($p['price'], 2)) ?></span></td>
                                            <td><?= esc($p['stock']) ?></td>
                                            <td><?= $p['image'] ? '<span class="badge bg-info">Yes</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox" style="font-size: 2rem;"></i><br>
                                            <strong>No products found.</strong> Add your first product!
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar Stats -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden product-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; transition: all 0.3s; height: 250px; display: flex; flex-direction: column; justify-content: center;">
                    <div class="card-body text-center">
                        <i class="bi bi-briefcase-fill" style="font-size: 3rem; opacity: 0.9;"></i>
                        <h6 class="mt-3 mb-3 opacity-75">Total Products</h6>
                        <h2 class="fw-bold" style="font-size: 3rem;"><?= count($products) ?></h2>
                    </div>
                </div>

                <div class="card shadow-lg border-0 rounded-lg overflow-hidden product-card mt-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; transition: all 0.3s; height: 250px; display: flex; flex-direction: column; justify-content: center;">
                    <div class="card-body text-center">
                        <i class="bi bi-stack" style="font-size: 3rem; opacity: 0.9;"></i>
                        <h6 class="mt-3 mb-3 opacity-75">Total Stock</h6>
                        <h2 class="fw-bold" style="font-size: 3rem;"><?= array_sum(array_column($products, 'stock')) ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

<style>
    /* Header Section Gradient */
    .head-admin {
        background: linear-gradient(to right, #007bff, #00bcd4);
        color: white;
        padding: 60px 0;
        text-align: center;
        margin-top: 70px;
    }

    /* Body Spacing */
    body {
        background: #f8f9fa;
        padding-top: 0;
    }

    /* Card Styling */
    .card {
        border-radius: 15px;
        border: none;
    }

    /* Table Hover Effect */
    .table-hover tbody tr:hover {
        background-color: #f0f3ff;
    }

    /* Collapse Animation */
    .collapse.show {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Image Drop Zone */
    #imageDropZone {
        cursor: pointer;
        transition: all 0.3s;
        border: 2px dashed #dee2e6;
        border-radius: 15px;
    }

    #imageDropZone:hover {
        background-color: #f0f8ff !important;
        border-color: #007bff !important;
    }

    /* Stat Cards Hover */
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
    }

    /* Button Styling */
    .btn-primary {
        background: linear-gradient(to right, #007bff, #00bcd4);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(to right, #0056b3, #0097a7);
    }

    /* Alert Styling */
    .alert {
        border-radius: 15px;
        border: none;
    }

    /* Form Controls */
    .form-control, .form-control-lg {
        border-radius: 10px;
        border: 1px solid #dee2e6;
        transition: all 0.3s;
    }

    .form-control:focus, .form-control-lg:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Badge Styling */
    .badge {
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-size: 0.85rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .head-admin {
            padding: 40px 0;
        }
        
        .card {
            margin-bottom: 1rem;
        }
    }
</style>

<script>
    // File upload drag and drop
    const imageDropZone = document.getElementById('imageDropZone');
    const imageInput = document.getElementById('imageInput');

    imageDropZone.addEventListener('click', () => imageInput.click());

    imageDropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        imageDropZone.classList.add('bg-light');
    });

    imageDropZone.addEventListener('dragleave', () => {
        imageDropZone.classList.remove('bg-light');
    });

    imageDropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        imageDropZone.classList.remove('bg-light');
        imageInput.files = e.dataTransfer.files;
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
