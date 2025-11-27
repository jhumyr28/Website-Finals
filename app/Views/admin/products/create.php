<section class="container py-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Add Product</h2>

            <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <?php foreach(session()->getFlashdata('errors') as $e): ?>
                        <div><?= esc($e) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/products/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" value="<?= esc(old('name')) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" value="<?= esc(old('slug')) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4"><?= esc(old('description')) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price (₱)</label>
                    <input type="number" name="price" value="<?= esc(old('price')) ?>" step="0.01" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" value="<?= esc(old('stock', '0')) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-success">Add Product</button>
                <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</section>
