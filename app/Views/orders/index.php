<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12 mb-4"><h3 class="fw-bold">Riwayat Pesanan</h3></div>
    <?php if(empty($orders)): ?>
        <div class="col-12"><p class="text-center">Belum ada pesanan.</p></div>
    <?php else: ?>
        <?php foreach($orders as $o): ?>
        <div class="col-md-6 mb-4">
            <div class="card h-100 p-4 border-0 shadow-sm rounded-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-primary">Pesanan #ORD-<?= str_pad($o['id_order'], 4, '0', STR_PAD_LEFT) ?></h5>
                </div>
                <p class="mb-1">Total Harga: <strong>Rp <?= number_format($o['total_price']) ?></strong></p>
                <hr>
                <div class="p-3 text-center rounded-4 shadow-sm fw-bold <?= ($o['status'] == 'Pending') ? 'bg-warning text-dark' : ($o['status'] == 'Diproses' ? 'bg-info text-dark' : 'bg-success text-white') ?>" style="font-size: 1.2rem; letter-spacing: 1px;">
                    STATUS: <?= strtoupper($o['status']) ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>