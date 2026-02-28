<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<style>
    .banner {
        background: linear-gradient(135deg, #4DB6AC 0%, #80CBC4 100%);
        border-radius: 24px;
        padding: 40px;
        color: white;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(77, 182, 172, 0.2);
    }
    .banner::after {
        content: '';
        position: absolute;
        right: -50px;
        top: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    .action-card {
        background: #fff;
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        transition: var(--transition);
        border: none;
        box-shadow: var(--card-shadow);
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }
    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .action-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 12px;
    }
    .bg-soft-teal { background: #E0F2F1; color: #4DB6AC; }
    .bg-soft-pink { background: #FCE4EC; color: #F06292; }
    .bg-soft-orange { background: #FFF3E0; color: #FFB74D; }
    .bg-soft-purple { background: #F3E5F5; color: #9575CD; }

    .stat-row {
        background: #fff;
        border-radius: 15px;
        padding: 15px 20px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .stat-label { color: #90A4AE; font-size: 0.9rem; }
    .stat-value { font-weight: 700; color: #263238; }

    .badge-in { background: #E8F5E9; color: #2E7D32; border-radius: 8px; padding: 5px 12px; font-weight: 600; font-size: 0.75rem; }
    .badge-out { background: #FFEBEE; color: #C62828; border-radius: 8px; padding: 5px 12px; font-weight: 600; font-size: 0.75rem; }
</style>

<div class="banner">
    <div class="row align-items-center">
        <div class="col-md-7">
            <h2 class="fw-bold mb-2">Stock and Inventory</h2>
            <h2 class="fw-bold mb-3">Management System</h2>
            <p class="mb-0 opacity-75">Visualise and manage your warehouse data in one place with real-time analytics.</p>
        </div>
        <div class="col-md-5 text-end d-none d-md-block">
            <i class="fa fa-warehouse fa-5x opacity-25"></i>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Active Role Based Actions -->
    <?php if (session()->get('role') == 'admin') : ?>
        <div class="col-6 col-md-3">
            <a href="<?= base_url('inventory') ?>" class="action-card">
                <div class="action-icon bg-soft-pink"><i class="fa fa-box"></i></div>
                <span class="fw-bold">All Products</span>
                <small class="text-muted d-block mt-1">Manage items</small>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="<?= base_url('categories') ?>" class="action-card">
                <div class="action-icon bg-soft-orange"><i class="fa fa-tag"></i></div>
                <span class="fw-bold">Categories</span>
                <small class="text-muted d-block mt-1">Organize stock</small>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="<?= base_url('suppliers') ?>" class="action-card">
                <div class="action-icon bg-soft-teal"><i class="fa fa-truck"></i></div>
                <span class="fw-bold">Suppliers</span>
                <small class="text-muted d-block mt-1">Key partners</small>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="<?= base_url('orders/manage') ?>" class="action-card">
                <div class="action-icon bg-soft-purple"><i class="fa fa-history"></i></div>
                <span class="fw-bold">Transactions</span>
                <small class="text-muted d-block mt-1">Order queue</small>
            </a>
        </div>
    <?php else : ?>
        <div class="col-6 col-md-3">
            <a href="<?= base_url('inventory') ?>" class="action-card">
                <div class="action-icon bg-soft-teal"><i class="fa fa-shopping-basket"></i></div>
                <span class="fw-bold">Buy Items</span>
                <small class="text-muted d-block mt-1">Shop now</small>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="<?= base_url('orders/cart') ?>" class="action-card">
                <div class="action-icon bg-soft-pink"><i class="fa fa-shopping-cart"></i></div>
                <span class="fw-bold">My Cart</span>
                <small class="text-muted d-block mt-1">Checkout</small>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="<?= base_url('orders') ?>" class="action-card">
                <div class="action-icon bg-soft-orange"><i class="fa fa-receipt"></i></div>
                <span class="fw-bold">My Orders</span>
                <small class="text-muted d-block mt-1">Track status</small>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="<?= base_url('profile') ?>" class="action-card">
                <div class="action-icon bg-soft-purple"><i class="fa fa-cog"></i></div>
                <span class="fw-bold">Settings</span>
                <small class="text-muted d-block mt-1">My profile</small>
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Scrollable Content Section -->
<div class="row">
    <!-- Summary Section -->
    <div class="col-lg-6 mb-4">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold m-0 text-dark">System Summary</h5>
            <small class="text-muted"><i class="fa fa-sync-alt me-1"></i> Real-time</small>
        </div>
        
        <div class="stat-row">
            <span class="stat-label">Total Items in Catalog</span>
            <span class="stat-value"><?= $total_products ?> Items</span>
        </div>
        <div class="stat-row">
            <span class="stat-label">Low Stock Alerts</span>
            <span class="stat-value text-danger fs-5 fw-bold"><?= $low_stock ?> Items</span>
        </div>
        <div class="stat-row border-start border-4 border-primary">
            <span class="stat-label ps-2">Orders Successfully Processed</span>
            <span class="stat-value text-success"><?= $total_entries ?></span>
        </div>
    </div>

    <!-- Quick Guide Section -->
    <div class="col-lg-6 mb-4">
        <div class="mb-4">
            <h5 class="fw-bold m-0 text-dark">Quick Guide: What can you do?</h5>
            <p class="text-muted small">Learn how to navigate through the system with ease.</p>
        </div>
        
        <div class="card border-0 shadow-sm" style="border-radius: 20px; background: #F8FBFB;">
            <div class="card-body p-4">
                <div class="d-flex mb-3">
                    <div class="me-3"><i class="fa fa-check-circle text-primary"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Check Your Stock</h6>
                        <small class="text-muted">Click on "All Products" to see what's available and edit stock levels.</small>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <div class="me-3"><i class="fa fa-shopping-cart text-primary"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Restock or Order</h6>
                        <small class="text-muted">Use "Buy Items" to add new products to your warehouse or create an order.</small>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="me-3"><i class="fa fa-chart-line text-primary"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Analyze Data</h6>
                        <small class="text-muted">Review "Transactions" to see order history and performance analytics.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold m-0 text-dark">Recent Activity Feed</h5>
            <a href="<?= base_url('orders/manage') ?>" class="btn btn-sm text-primary p-0 fw-bold">Full History <i class="fa fa-external-link-alt small"></i></a>
        </div>
        
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="min-width: 600px;">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted border-0" style="font-size: 0.75rem; text-transform: uppercase;">Status</th>
                                <th class="py-3 text-muted border-0" style="font-size: 0.75rem; text-transform: uppercase;">Customer</th>
                                <th class="py-3 text-muted border-0 text-center" style="font-size: 0.75rem; text-transform: uppercase;">Value</th>
                                <th class="pe-4 py-3 text-muted border-0 text-end" style="font-size: 0.75rem; text-transform: uppercase;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($recent_orders as $order): ?>
                            <tr>
                                <td class="ps-4">
                                    <?php 
                                        $badgeClass = 'badge-out'; // Default
                                        if($order['status'] == 'Selesai') $badgeClass = 'badge-in';
                                    ?>
                                    <span class="<?= $badgeClass ?>">
                                        <?= strtoupper($order['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark"><?= $order['full_name'] ?? 'Guest User' ?></div>
                                    <small class="text-muted">Order ID: #ORD-<?= str_pad($order['id_order'], 4, '0', STR_PAD_LEFT) ?></small>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill bg-light text-dark px-3 py-2 border">Rp <?= number_format($order['total_price']) ?></span>
                                </td>
                                <td class="text-end pe-4">
                                    <span class="text-muted small fw-medium"><?= date('M d, Y', strtotime($order['created_at'])) ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($recent_orders)): ?>
                            <tr><td colspan="4" class="text-center py-5 text-muted">Initialize your first transaction to see activity here.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
