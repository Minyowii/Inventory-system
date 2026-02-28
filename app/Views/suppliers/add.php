<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>
<div class="card p-4 border-0 shadow-sm rounded-4">
    <h4 class="fw-bold mb-4">Tambah Supplier</h4>
    <form action="<?= base_url('suppliers/store') ?>" method="post">
        <div class="mb-3">
            <label>Nama Supplier</label>
            <input type="text" name="SupplierName" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="Email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>No. Telepon</label>
            <input type="text" name="PhoneNumber" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary rounded-pill px-4" style="background: var(--primary-color); border: none;">Simpan</button>
        <a href="<?= base_url('suppliers') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?= $this->endSection() ?>
