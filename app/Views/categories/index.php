<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>
<style>
    .category-card {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .category-card:hover { transform: translateY(-5px); }
    .category-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 1.25rem;
    }
    .category-teal { background: #E0F2F1; color: #4DB6AC; }
    .category-pink { background: #FCE4EC; color: #F06292; }
    .category-orange { background: #FFF3E0; color: #FFB74D; }
    .category-purple { background: #F3E5F5; color: #9575CD; }
</style>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h4 class="fw-bold mb-1">Product Categories</h4>
        <p class="text-muted small mb-0">Organize your inventory by grouping products into categories.</p>
    </div>
    <?php if(session()->get('role') == 'admin'): ?>
        <a href="<?= base_url('categories/add') ?>" class="btn btn-primary rounded-pill px-4" style="background: var(--primary-color); border: none; font-weight: 600;">
            <i class="fa fa-plus me-2"></i> Add Category
        </a>
    <?php endif; ?>
</div>

<div class="row g-4">
    <?php 
        $colors = ['teal', 'pink', 'orange', 'purple'];
        foreach($categories as $index => $c): 
            $colorClass = 'category-' . $colors[$index % 4];
    ?>
    <div class="col-md-6 col-xl-4">
        <div class="category-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="category-icon <?= $colorClass ?>">
                    <i class="fa fa-tag"></i>
                </div>
                <?php if(session()->get('role') == 'admin'): ?>
                <div class="dropdown">
                    <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                        <li><a class="dropdown-item py-2" href="<?= base_url('categories/edit/'.$c['id_category']) ?>"><i class="fa fa-pen me-2 text-primary"></i> Edit</a></li>
                        <li><a class="dropdown-item py-2 text-danger" href="<?= base_url('categories/delete/'.$c['id_category']) ?>" onclick="return confirm('Hapus kategori ini?')"><i class="fa fa-trash me-2"></i> Delete</a></li>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
            
            <h5 class="fw-bold text-dark mb-2"><?= $c['name'] ?></h5>
            <p class="small text-muted mb-4 flex-grow-1"><?= $c['description'] ?: 'No description available for this category.' ?></p>
            
            <a href="<?= base_url('inventory?category_id='.$c['id_category']) ?>" class="btn btn-light rounded-pill w-100 py-2 fw-bold text-primary" style="background: #F5FBFB; border: 1px solid #E0F2F1;">
                View Products <i class="fa fa-arrow-right ms-2 small"></i>
            </a>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if(empty($categories)): ?>
        <div class="col-12 text-center py-5">
            <i class="fa fa-folder-open fa-3x text-light mb-3"></i>
            <p class="text-muted">No categories found yet.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>