<section class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <img src="<?= base_url('uploads/' . ($product['image'] ?? 'placeholder.png')) ?>" class="card-img-top" alt="<?= esc($product['name']) ?>">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="mb-3"><?= esc($product['name']) ?></h1>
            <h3 class="text-muted">₱<?= esc(number_format($product['price'], 2)) ?></h3>
            <p class="mt-4"><?= nl2br(esc($product['description'])) ?></p>

            <form action="<?= base_url('cart/add') ?>" method="post" class="mt-4">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" value="<?= esc($product['id']) ?>">

                <div class="mb-3" style="max-width:120px;">
                    <label for="qty" class="form-label">Quantity</label>
                    <input id="qty" name="quantity" type="number" min="1" value="1" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary btn-lg">Add to Cart</button>
                <a href="<?= base_url('/') ?>" class="btn btn-link">Continue shopping</a>
            </form>
        </div>
    </div>
</section>
<h2><?php echo esc($product['name']); ?></h2>
<p>Price: ₱<?php echo number_format($product['price'],2); ?></p>
<p><?php echo nl2br(esc($product['description'])); ?></p>

<form method="post" action="/cart/add">
  <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
  <label>Qty: <input type="number" name="qty" value="1" min="1"></label>
  <button type="submit">Add to cart</button>
</form>
