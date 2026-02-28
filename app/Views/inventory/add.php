<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg p-4 border-0">
                <h3 class="mb-4 fw-bold">Tambah Inventori</h3>
                <form action="<?= base_url('inventory/store') ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Barang</label>
                        <input type="text" name="ItemName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah (Quantity)</label>
                        <input type="number" name="Quantity" class="form-control" required min="1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Supplier</label>
                        <select name="SupplierID" class="form-select">
                            <?php foreach($suppliers as $s): ?>
                                <option value="<?= $s['SupplierID'] ?>"><?= $s['SupplierName'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="category_id" class="form-select">
                            <?php foreach($categories as $c): ?>
                                <option value="<?= $c['id_category'] ?>"><?= $c['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="<?= base_url('inventory') ?>" class="btn btn-secondary w-50">Batal</a>
                        <button type="submit" class="btn btn-primary w-50" style="background-color: #1976D2;">Simpan Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>