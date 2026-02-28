<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>
<style>
    .card-premium {
        background: #fff;
        border-radius: 24px;
        padding: 30px;
        border: none;
        box-shadow: var(--card-shadow);
    }
    .table-modern thead th {
        background: #F8FBFB;
        color: #90A4AE;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border: none;
        padding: 15px 20px;
    }
    .table-modern tbody td {
        padding: 18px 20px;
        border-bottom: 1px solid #F1F1F1;
        color: #455A64;
    }
    .supplier-name {
        font-weight: 600;
        color: #263238;
        display: block;
    }
    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        border: none;
    }
    .btn-edit { background: #E1F5FE; color: #0288D1; }
    .btn-delete { background: #FFEBEE; color: #E57373; }
    
    .btn-action:hover {
        transform: translateY(-2px);
        filter: brightness(0.95);
    }
</style>

<div class="card-premium">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">Key Suppliers</h4>
            <p class="text-muted small mb-0">Manage your product suppliers and their contact information.</p>
        </div>
        <a href="<?= base_url('suppliers/add') ?>" class="btn btn-primary rounded-pill px-4" style="background: var(--primary-color); border: none; font-weight: 600;">
            <i class="fa fa-plus me-2"></i> Add Supplier
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-modern align-middle mb-0">
            <thead>
                <tr>
                    <th>Supplier Details</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <!-- <th>Address</th> (Address column existed in original but maybe hide or refine) -->
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($suppliers as $s): ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="me-3 bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; color: var(--primary-color);">
                                <i class="fa fa-truck fa-lg"></i>
                            </div>
                            <div>
                                <span class="supplier-name"><?= $s['SupplierName'] ?></span>
                            </div>
                        </div>
                    </td>
                    <td><?= $s['Email'] ?></td>
                    <td>
                        <span class="badge rounded-pill bg-light text-dark px-3 py-2 border">
                            <i class="fa fa-phone me-1 small"></i> <?= $s['PhoneNumber'] ?>
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= base_url('suppliers/edit/'.$s['SupplierID']) ?>" class="btn-action btn-edit" title="Edit Supplier"><i class="fa fa-pen"></i></a>
                            <a href="<?= base_url('suppliers/delete/'.$s['SupplierID']) ?>" class="btn-action btn-delete" title="Delete Supplier" onclick="return confirm('Hapus supplier ini?')"><i class="fa fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($suppliers)): ?>
                    <tr><td colspan="4" class="text-center py-5 text-muted">No suppliers found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>