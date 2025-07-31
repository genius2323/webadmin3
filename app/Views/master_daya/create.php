<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="form-container" style="max-width: 480px; margin: 0 auto;">
    <div class="page-header" style="display:flex;align-items:center;gap:16px;margin-left:24px;margin-bottom:18px;">
        <div class="page-header-icon" style="display:flex;align-items:center;">
            <span class="material-symbols-outlined" style="font-size:2.2rem;">bolt</span>
        </div>
        <div>
            <h1 class="page-header-title" style="margin:0;">Master Daya</h1>
            <p class="page-header-subtitle" style="margin:0;">Kelola seluruh data daya di sini.</p>
        </div>
    </div>
    <div class="content-card">
        <?php if (session('success')): ?>
            <div class="alert alert-success">
                <span class="material-symbols-outlined alert-icon">check_circle</span>
                <span><?= session('success') ?></span>
                <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        <?php endif; ?>
        <form action="<?= site_url('masterdaya/save') ?>" method="post" autocomplete="off">
            <div class="form-group">
                <label for="name" class="form-label">Nama Daya<span style="color:red">*</span></label>
                <input type="text" name="name" id="name" class="form-m3-input input-m3-date" required placeholder="Nama Daya">
            </div>
            <div class="form-group">
                <label for="description" class="form-label">Deskripsi</label>
                <input type="text" name="description" id="description" class="form-m3-input input-m3-date" placeholder="Deskripsi">
            </div>
            <div class="form-actions" style="display:flex;justify-content:flex-end;margin-top:32px;gap:10px;">
                <button type="submit" class="btn-m3 btn-primary-m3">
                    <span class="material-symbols-outlined" style="vertical-align: middle;">save</span>
                    Simpan
                </button>
                <a href="<?= site_url('masterdaya') ?>" class="btn-logout-modern" style="background:#e53935;color:#fff;">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
