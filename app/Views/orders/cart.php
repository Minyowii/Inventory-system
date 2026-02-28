<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>
<div class="card p-4 border-0 shadow-sm rounded-4">
    <h4 class="fw-bold mb-4">🛒 Keranjang Belanja</h4>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th class="text-end">Harga</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if($cart): ?>
                    <?php foreach($cart as $id => $item): ?>
                    <tr>
                        <td><strong><?= $item['name'] ?></strong></td>
                        <td><?= $item['quantity'] ?></td>
                        <td class="text-end">Rp <?= number_format($item['price'] * $item['quantity']) ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('orders/remove_cart/'.$id) ?>" class="btn btn-sm btn-danger rounded-circle">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center py-5">Keranjang kosong.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($cart): ?>
    <div class="text-end mt-4">
        <form action="<?= base_url('orders/checkout') ?>" method="post">
            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">Checkout Sekarang</button>
        </form>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>