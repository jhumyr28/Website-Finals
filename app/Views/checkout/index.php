<section class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2>Checkout</h2>

            <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <?php foreach(session()->getFlashdata('errors') as $e): ?>
                        <div><?= esc($e) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('checkout/place') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Full name</label>
                    <input type="text" name="name" value="<?= esc(old('name')) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="<?= esc(old('email')) ?>" class="form-control" required>
                </div>

                <h4 class="mt-4">Order summary</h4>
                <ul class="list-group mb-3">
                    <?php foreach($cart as $item): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?= esc($item['name']) ?></strong>
                                <div class="text-muted">Qty: <?= esc($item['qty']) ?></div>
                            </div>
                            <div>₱<?= esc(number_format($item['price'] * $item['qty'], 2)) ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <button class="btn btn-success btn-lg" type="submit">Place Order</button>
            </form>
        </div>
    </div>
</section>
