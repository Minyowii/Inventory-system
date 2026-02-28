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
    .order-id { font-weight: 700; color: var(--primary-color); }
    .status-badge {
        padding: 6px 14px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .bg-pending { background: #FFF3E0; color: #E65100; }
    .bg-process { background: #E1F5FE; color: #0288D1; }
    .bg-done { background: #E8F5E9; color: #2E7D32; }
</style>

<div class="card-premium">
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Queue Management</h4>
        <p class="text-muted small mb-0">Track and update the status of incoming customer product orders.</p>
    </div>

    <div class="table-responsive">
        <table class="table table-modern align-middle mb-0">
            <thead>
                <tr>
                    <th>Order & Customer</th>
                    <th>Total Value</th>
                    <th>Current Status</th>
                    <th class="text-end">Manage Order</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($orders)): ?>
                    <tr><td colspan="4" class="text-center py-5 text-muted">No active orders in queue.</td></tr>
                <?php else: ?>
                    <?php foreach($orders as $o): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-3 bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; color: var(--primary-color);">
                                    <i class="fa fa-receipt fa-lg"></i>
                                </div>
                                <div>
                                    <span class="order-id">#ORD-<?= str_pad($o['id_order'], 4, '0', STR_PAD_LEFT) ?></span>
                                    <small class="text-muted d-block"><?= $o['full_name'] ?? 'Guest User' ?></small>
                                </div>
                            </div>
                        </td>
                        <td class="fw-bold">Rp <?= number_format($o['total_price']) ?></td>
                        <td>
                            <?php 
                                $statusClass = 'bg-pending';
                                if($o['status'] == 'Diproses') $statusClass = 'bg-process';
                                elseif($o['status'] == 'Selesai') $statusClass = 'bg-done';
                            ?>
                            <span class="status-badge <?= $statusClass ?>"><?= $o['status'] ?></span>
                        </td>
                        <td class="text-end">
                            <form action="<?= base_url('orders/update_status/'.$o['id_order']) ?>" method="post" class="d-flex gap-2 justify-content-end align-items-center">
                                <select name="status" class="form-select form-select-sm rounded-pill px-3" style="width: auto; background-color: #F8FBFB; border: 1px solid #E0F2F1;">
                                    <option value="Pending" <?= $o['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Diproses" <?= $o['status'] == 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                                    <option value="Selesai" <?= $o['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3" style="background: var(--primary-color); border: none;">Save</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>