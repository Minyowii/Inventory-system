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
    .item-name {
        font-weight: 600;
        color: #263238;
        display: block;
    }
    .stock-badge {
        padding: 6px 14px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .stock-high { background: #E8F5E9; color: #2E7D32; }
    .stock-low { background: #FFF3E0; color: #E65100; }
    .stock-out { background: #FFEBEE; color: #C62828; }
    
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
    .btn-view { background: #F3E5F5; color: #9575CD; }
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
            <h4 class="fw-bold mb-1">Inventory Management</h4>
            <p class="text-muted small mb-0">Track and manage your products across all warehouses.</p>
        </div>
        <div class="d-flex gap-2">
            <form action="<?= base_url('inventory') ?>" method="get" class="d-flex position-relative">
                <input type="text" name="search" class="form-control rounded-pill ps-4 pe-5" placeholder="Search product..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" style="font-size: 0.9rem; background: #F5FBFB; border: 1px solid #E0F2F1;">
                <button type="submit" class="btn position-absolute end-0 top-0 h-100 border-0" style="color: var(--primary-color);"><i class="fa fa-search"></i></button>
            </form>
            <?php if(session()->get('role') == 'admin'): ?>
                <a href="<?= base_url('inventory/add') ?>" class="btn btn-primary rounded-pill px-4" style="background: var(--primary-color); border: none; font-weight: 600;">
                    <i class="fa fa-plus me-2"></i> Add Item
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-modern align-middle mb-0">
            <thead>
                <tr>
                    <th>Product Details</th>
                    <th class="text-center">Current Stock</th>
                    <th class="text-center">Category</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $row): ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="me-3 bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; color: var(--primary-color);">
                                <i class="fa fa-cube fa-lg"></i>
                            </div>
                            <span class="item-name"><?= $row['ItemName'] ?></span>
                        </div>
                    </td>
                    <td class="text-center">
                        <?php 
                            $stockClass = 'stock-high';
                            if($row['Quantity'] <= 0) $stockClass = 'stock-out';
                            elseif($row['Quantity'] < 10) $stockClass = 'stock-low';
                        ?>
                        <span class="stock-badge <?= $stockClass ?>">
                            <?= $row['Quantity'] ?> Units
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge rounded-pill bg-light text-dark px-3 py-2 border">General</span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= base_url('inventory/show/'.$row['ItemID']) ?>" class="btn-action btn-view" title="View Detail"><i class="fa fa-eye"></i></a>

                            <?php if(session()->get('role') == 'admin'): ?>
                                <a href="<?= base_url('inventory/edit/'.$row['ItemID']) ?>" class="btn-action btn-edit" title="Edit Item"><i class="fa fa-pen"></i></a>
                                <a href="<?= base_url('inventory/delete/'.$row['ItemID']) ?>" class="btn-action btn-delete" title="Delete Item" onclick="return confirm('Hapus barang ini?')"><i class="fa fa-trash"></i></a>
                            <?php else: ?>
                                <form action="<?= base_url('orders/add_to_cart') ?>" method="post" class="d-flex gap-2">
                                    <input type="hidden" name="item_id" value="<?= $row['ItemID'] ?>">
                                    <div class="input-group input-group-sm" style="width: 130px;">
                                        <input type="number" name="quantity" value="1" min="1" max="<?= $row['Quantity'] ?>" class="form-control border-end-0 rounded-start-pill ps-3">
                                        <button type="submit" class="btn btn-success rounded-end-pill px-3">
                                            <i class="fa fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($items)): ?>
                    <tr><td colspan="4" class="text-center py-5 text-muted">No products found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>