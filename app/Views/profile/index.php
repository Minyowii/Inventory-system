<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>
<div class="card p-4 border-0 shadow-sm rounded-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Informasi Profil</h4>
        <a href="<?= base_url('profile/edit') ?>" class="btn text-white px-4 rounded-pill" style="background-color: #1976D2;">
            <i class="fa fa-edit me-1"></i> Edit Profil
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless align-middle">
            <tr><th width="200" class="text-muted small">USERNAME</th><td>: <strong><?= $user['username'] ?></strong></td></tr>
            <tr><th class="text-muted small">NAMA LENGKAP</th><td>: <?= $user['full_name'] ?></td></tr>
            <tr><th class="text-muted small">EMAIL</th><td>: <?= $user['email'] ?></td></tr>
            <tr><th class="text-muted small">ROLE</th><td>: <span class="badge bg-info text-dark px-3"><?= strtoupper($user['role']) ?></span></td></tr>
        </table>
    </div>
</div>
<?= $this->endSection() ?>