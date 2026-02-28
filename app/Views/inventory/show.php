<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>
<div class="container mt-2">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-bold text-primary"><i class="fa-solid fa-circle-info me-2"></i>Informasi Produk</h5>
        </div>
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-4 text-center">
                    <i class="fa-solid fa-box-open text-secondary mb-3" style="font-size: 8rem; opacity: 0.3;"></i>
                </div>
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1"><?= $result['ItemName'] ?></h2>
                    <span class="badge bg-light text-primary border border-primary mb-4 px-3"><?= $result['category_name'] ?></span>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="text-muted small d-block">Stok Tersedia</label>
                            <span class="h4 fw-bold"><?= $result['Quantity'] ?> Unit</span>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small d-block">Supplier Utama</label>
                            <span class="h5 fw-bold"><?= $result['supplier_name'] ?? 'Tidak Terdaftar' ?></span>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="d-flex gap-2">
                        <a href="<?= base_url('inventory') ?>" class="btn btn-secondary px-4">Kembali</a>
                        <?php if(session()->get('role') == 'user'): ?>
                            <a href="<?= base_url('orders/create/'.$result['ItemID']) ?>" class="btn btn-success px-4">Pesan Sekarang</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>