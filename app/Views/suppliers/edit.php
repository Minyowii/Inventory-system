<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>
<div class="card p-4 border-0 shadow-sm rounded-4">
    <h4 class="fw-bold mb-4">Edit Supplier</h4>
    <form action="<?= base_url('suppliers/update/'.$supplier['SupplierID']) ?>" method="post">
        <div class="mb-3">
            <label>Nama Supplier</label>
            <input type="text" name="SupplierName" class="form-control" value="<?= $supplier['SupplierName'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="Email" class="form-control" value="<?= $supplier['Email'] ?>" required>
        </div>
        <div class="mb-3">
            <label>No. Telepon</label>
            <input type="text" name="PhoneNumber" class="form-control" value="<?= $supplier['PhoneNumber'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary rounded-pill px-4" style="background: var(--primary-color); border: none;">Update</button>
        <a href="<?= base_url('suppliers') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?= $this->endSection() ?>
