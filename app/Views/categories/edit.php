<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>
<div class="card p-4 border-0 shadow-sm rounded-4">
    <h4 class="fw-bold mb-4">Edit Kategori</h4>
    <form action="<?= base_url('categories/update/'.$category['id_category']) ?>" method="post">
        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="name" class="form-control" value="<?= $category['name'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" required><?= $category['description'] ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('categories') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?= $this->endSection() ?>
