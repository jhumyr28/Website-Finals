<?php echo view('templates/header'); ?>

<div class="container py-5">
    <h2 class="mb-4">
        <i class="bi bi-bag-check me-2"></i>Your Shopping Cart
    </h2>
    
    <?php if(empty($cart)): ?>
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.5;"></i>
            <p class="mt-3 mb-0">Your cart is empty. <a href="<?= base_url('/') ?>">Continue shopping</a></p>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Color</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0; foreach($cart as $cartKey => $item): $subtotal = $item['qty'] * $item['price']; $total += $subtotal; ?>
                                    <tr>
                                        <td>
                                            <?php 
                                                $productLink = base_url('product/' . ($item['slug'] ?? 'unknown'));
                                                if(isset($item['slug'])): 
                                            ?>
                                                <a href="<?= $productLink ?>" class="text-decoration-none fw-bold">
                                                    <?= esc($item['name']) ?>
                                                </a>
                                            <?php else: ?>
                                                <strong><?= esc($item['name']) ?></strong>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="badge bg-primary"><?= esc($item['color'] ?? 'Default') ?></span></td>
                                        <td>
                                            <form method="post" action="<?= base_url('cart/update') ?>" class="d-flex align-items-center gap-2">
                                                <input type="hidden" name="product_id" value="<?= esc($cartKey) ?>">
                                                <input type="number" name="quantity" value="<?= $item['qty'] ?>" min="1" class="form-control" style="width: 70px;" onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td>₱<?= number_format($item['price'], 2) ?></td>
                                        <td><strong>₱<?= number_format($subtotal, 2) ?></strong></td>
                                        <td>
                                            <form method="post" action="<?= base_url('cart/remove') ?>" class="d-inline">
                                                <input type="hidden" name="product_id" value="<?= esc($cartKey) ?>">
                                                <button type="submit" class="btn btn-sm btn-danger" title="Remove">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Order Summary</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>₱<?= number_format($total, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span>₱100.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3" style="opacity: 0.9;">
                            <span>Tax:</span>
                            <span>₱<?= number_format($total * 0.12, 2) ?></span>
                        </div>
                        
                        <hr class="my-3" style="background-color: rgba(255,255,255,0.3);">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <strong>Total:</strong>
                            <h3 class="mb-0">₱<?= number_format($total + 100 + ($total * 0.12), 2) ?></h3>
                        </div>
                        
                        <a href="<?= base_url('checkout') ?>" class="btn btn-light btn-lg w-100 fw-bold">
                            <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                        </a>
                    </div>
                </div>

                <div class="card shadow border-0 rounded-lg mt-3">
                    <div class="card-body text-center">
                        <i class="bi bi-shield-check text-success me-2"></i>
                        <small class="text-muted">Secure checkout powered by SSL encryption</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="<?= base_url('/') ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>Continue Shopping
            </a>
        </div>
    <?php endif; ?>
</div>
