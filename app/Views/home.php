<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Website</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url('css/home.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>

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
                <li class="nav-item"><a class="nav-link active" href="<?= base_url('/') ?>">Home</a></li>
                
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

    <!-- Head Section -->
    <section class="head">
        <div class="container">
            <h1 class="display-4 fw-bold">Welcome to Apparel</h1>
            <p class="lead">Your one-stop shop for amazing products.</p>
        </div>
    </section>

    <!-- Featured Products -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">
            <i class="bi bi-star-fill text-warning me-2"></i>Featured Products
        </h2>
        <div class="row g-4">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $p): ?>
                    <div class="col-md-3">
                        <div class="card product-card">
                            <?php
                                $imagePath = base_url('uploads/' . $p['image']);
                                $defaultImage = base_url('uploads/tshirt.jpg');
                            ?>
                            <img src="<?= $imagePath ?>" 
                                 alt="<?= esc($p['name']) ?>"
                                 class="card-img-top"
                                 onerror="this.src='<?= $defaultImage ?>'">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= esc($p['name']) ?></h5>
                                <p class="card-text text-muted">₱<?= esc(number_format($p['price'], 2)) ?></p>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addToCartModal" 
                                        onclick="setProductData(<?= esc($p['id']) ?>, '<?= esc($p['name']) ?>', <?= esc($p['price']) ?>, <?= esc($p['stock']) ?>)">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No products available yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Add to Cart Modal -->
<div class="modal fade" id="addToCartModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-lg border-0">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-bag-check me-2"></i><span id="modalProductName"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted">Product Price</label>
                    <h4 class="text-success fw-bold">₱<span id="modalPrice">0.00</span></h4>
                </div>

                <!-- Color Selection -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-palette me-2"></i>Select Color
                    </label>
                    <div id="colorOptions" class="d-flex gap-2 flex-wrap"></div>
                </div>

                <!-- Quantity Selection -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-box2 me-2"></i>Quantity
                    </label>
                    <div class="input-group">
                        <button class="btn btn-outline-secondary" type="button" onclick="decreaseQty()">
                            <i class="bi bi-dash"></i>
                        </button>
                        <input type="number" id="quantity" class="form-control text-center" value="1" min="1" onchange="updateTotalPrice()">
                        <button class="btn btn-outline-secondary" type="button" onclick="increaseQty()">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                    <small class="text-muted d-block mt-2"><span id="stockInfo"></span></small>
                </div>

                <!-- Total Price -->
                <div class="mb-4 p-3 rounded-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Total Price:</span>
                        <h4 class="mb-0">₱<span id="totalPrice">0.00</span></h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addToCartFromModal()">
                    <i class="bi bi-cart-check me-1"></i>Add to Cart
                </button>
            </div>
        </div>
    </div>
</div>

<?php echo view('templates/footer'); ?>

<script>
    // Define default colors for all products
    const defaultColors = ['White', 'Black', 'Red', 'Blue', 'Navy', 'Gray'];
    let currentProduct = { id: null, name: '', price: 0, stock: 0 };
    let selectedColor = null;

    function setProductData(id, name, price, stock) {
        currentProduct = { id, name, price, stock };
        document.getElementById('modalProductName').textContent = name;
        document.getElementById('modalPrice').textContent = parseFloat(price).toFixed(2);
        document.getElementById('quantity').value = 1;
        document.getElementById('stockInfo').textContent = `${stock} items available`;
        
        // Reset color selection
        selectedColor = null;
        renderColorOptions();
        updateTotalPrice();
    }

    function renderColorOptions() {
        const colorContainer = document.getElementById('colorOptions');
        colorContainer.innerHTML = '';
        
        defaultColors.forEach(color => {
            const colorBtn = document.createElement('button');
            colorBtn.type = 'button';
            colorBtn.className = 'btn btn-outline-secondary rounded-pill px-3 py-2';
            colorBtn.textContent = color;
            colorBtn.onclick = () => selectColor(color, colorBtn);
            colorContainer.appendChild(colorBtn);
        });
    }

    function selectColor(color, btn) {
        // Remove active class from all buttons
        document.querySelectorAll('#colorOptions button').forEach(b => {
            b.classList.remove('btn-primary');
            b.classList.add('btn-outline-secondary');
        });
        
        // Add active class to selected button
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-primary');
        selectedColor = color;
    }

    function increaseQty() {
        const input = document.getElementById('quantity');
        const newQty = parseInt(input.value) + 1;
        if (newQty <= currentProduct.stock) {
            input.value = newQty;
            updateTotalPrice();
        }
    }

    function decreaseQty() {
        const input = document.getElementById('quantity');
        const newQty = parseInt(input.value) - 1;
        if (newQty >= 1) {
            input.value = newQty;
            updateTotalPrice();
        }
    }

    function updateTotalPrice() {
        const quantity = parseInt(document.getElementById('quantity').value) || 1;
        const total = currentProduct.price * quantity;
        document.getElementById('totalPrice').textContent = total.toFixed(2);
    }

    function addToCartFromModal() {
        if (!selectedColor) {
            alert('Please select a color');
            return;
        }

        const quantity = parseInt(document.getElementById('quantity').value);
        
        // Create form data
        const formData = new FormData();
        formData.append('product_id', currentProduct.id);
        formData.append('quantity', quantity);
        formData.append('color', selectedColor);

        // Submit via fetch for AJAX handling
        fetch('<?= base_url('cart/add') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'ok') {
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('addToCartModal')).hide();
                
                // Show success toast
                showToast('✓ Added to cart!', `${quantity}x ${currentProduct.name} (${selectedColor})`);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function showToast(title, message) {
        const toastHtml = `
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div class="toast show border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="toast-body d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${title}</strong>
                            <div class="small">${message}</div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', toastHtml);
        
        // Auto remove toast after 3 seconds
        setTimeout(() => {
            const toast = document.querySelector('.toast');
            if (toast) toast.remove();
        }, 3000);
    }

    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>
