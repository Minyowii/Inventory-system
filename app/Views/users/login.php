<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="col-md-4">
        <div class="card shadow-lg">
            <div class="card-body p-5">
                <h2 class="text-center fw-bold mb-4">Login</h2>
                <?php if(session()->getFlashdata('msg')): ?>
                    <div class="alert alert-danger small py-2"><?= session()->getFlashdata('msg') ?></div>
                <?php endif; ?>
                <form action="<?= base_url('login/auth') ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>