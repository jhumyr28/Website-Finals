<section class="py-5" style="background: linear-gradient(135deg, rgba(0,123,255,0.1) 0%, rgba(0,188,212,0.1) 100%);">
    <div class="container">
        <div class="mb-4">
            <h1 class="display-5 fw-bold mb-2">
                <i class="bi bi-shop me-2"></i>Browse All Products
            </h1>
            <p class="text-muted">Explore our complete collection of apparel and fashion items</p>
        </div>

        <!-- Search & Filter Section -->
        <div class="row mb-4">
            <div class="col-md-6">
                <form method="get" class="input-group input-group-lg">
                    <input type="text" name="search" class="form-control rounded-start" 
                           placeholder="Search products..." value="<?= esc($search) ?>">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search me-1"></i>Search
                    </button>
                </form>
            </div>
            <div class="col-md-6">
                <form method="get" class="d-flex gap-2">
                    <?php if($search): ?>
                        <input type="hidden" name="search" value="<?= esc($search) ?>">
                    <?php endif; ?>
                    <label class="form-label mt-2 fw-semibold">Sort by:</label>
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="name" <?= $sort === 'name' ? 'selected' : '' ?>>Name (A-Z)</option>
                        <option value="price_low" <?= $sort === 'price_low' ? 'selected' : '' ?>>Price (Low to High)</option>
                        <option value="price_high" <?= $sort === 'price_high' ? 'selected' : '' ?>>Price (High to Low)</option>
                        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="row g-4">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $p): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card product-card h-100 shadow-lg border-0 rounded-lg overflow-hidden" style="transition: all 0.3s;">
                            <?php
                                $imagePath = base_url('uploads/' . $p['image']);
                                $defaultImage = base_url('uploads/tshirt.jpg');
                            ?>
                            <div style="position: relative; height: 250px; overflow: hidden; background: #f8f9fa;">
                                <img src="<?= $imagePath ?>" 
                                     alt="<?= esc($p['name']) ?>"
                                     class="w-100 h-100"
                                     style="object-fit: contain; padding: 15px;"
                                     onerror="this.src='".$defaultImage."'">
                                
                                <!-- Stock Badge -->
                                <div style="position: absolute; top: 10px; right: 10px;">
                                    <?php if($p['stock'] > 0): ?>
                                        <span class="badge bg-success" style="font-size: 0.85rem;">
                                            <i class="bi bi-check-circle me-1"></i><?= $p['stock'] ?> in stock
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger" style="font-size: 0.85rem;">
                                            <i class="bi bi-x-circle me-1"></i>Out of Stock
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold"><?= esc($p['name']) ?></h5>
                                <p class="card-text text-muted flex-grow-1" style="font-size: 0.9rem;">
                                    <?= esc(substr($p['description'], 0, 60)) ?>...
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="h5 mb-0 text-success fw-bold">
                                        ₱<?= number_format($p['price'], 2) ?>
                                    </span>
                                    <span class="text-muted small"><?= $p['stock'] ?> available</span>
                                </div>

                                <?php if($p['stock'] > 0): ?>
                                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#addToCartModal" 
                                            onclick="setProductData(<?= esc($p['id']) ?>, '<?= esc($p['name']) ?>', <?= esc($p['price']) ?>, <?= esc($p['stock']) ?>)">
                                        <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i class="bi bi-x-circle me-1"></i>Out of Stock
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                        <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.7;"></i>
                        <h5 class="mt-3">No products found</h5>
                        <p class="mb-0">
                            <?php if($search): ?>
                                No products match your search for "<?= esc($search) ?>". <a href="<?= base_url('products') ?>" class="text-white fw-bold">View all products</a>
                            <?php else: ?>
                                No products available at the moment.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if(!empty($products)): ?>
            <div class="mt-5 text-center">
                <p class="text-muted">
                    Showing <strong><?= count($products) ?></strong> product<?= count($products) !== 1 ? 's' : '' ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Add to Cart Modal (Same as home page) -->
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

<style>
    .product-card {
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15) !important;
    }

    .form-select {
        border-radius: 10px;
        border: 1px solid #dee2e6;
    }

    .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>

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
</script>
