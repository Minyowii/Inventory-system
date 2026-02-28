<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>
<div class="card p-4 col-md-6 border-0 shadow-sm rounded-4">
    <h4 class="fw-bold mb-4">Ubah Informasi Profil</h4>
    <form action="<?= base_url('profile/update') ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label fw-bold small text-muted">NAMA LENGKAP</label>
            <input type="text" name="full_name" class="form-control" value="<?= $user['full_name'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold small text-muted">EMAIL</label>
            <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn text-white px-4" style="background: #1976D2;">Simpan</button>
            <a href="<?= base_url('profile') ?>" class="btn btn-light border">Batal</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>