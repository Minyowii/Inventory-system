<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4 p-4">
        <h3 class="fw-bold mb-4">Edit Barang</h3>
        <form action="<?= base_url('inventory/update/' . $result['ItemID']) ?>" method="post">
            <?= csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Barang</label>
                <input type="text" name="ItemName" class="form-control" value="<?= $result['ItemName'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Jumlah (Quantity)</label>
                <input type="number" name="Quantity" class="form-control" value="<?= $result['Quantity'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Supplier</label>
                <select name="SupplierID" class="form-select">
                    <?php foreach($suppliers as $s): ?>
                        <option value="<?= $s['SupplierID'] ?>" <?= ($s['SupplierID'] == $result['SupplierID']) ? 'selected' : '' ?>>
                            <?= $s['SupplierName'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Kategori</label>
                <select name="category_id" class="form-select">
                    <?php foreach($categories as $c): ?>
                        <option value="<?= $c['id_category'] ?>" <?= ($c['id_category'] == $result['category_id']) ? 'selected' : '' ?>>
                            <?= $c['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 py-2" style="background-color: #1976D2;">Update Data</button>
                <a href="<?= base_url('inventory') ?>" class="btn btn-light border w-100">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>