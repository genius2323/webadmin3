<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-paint icon-gradient bg-tempting-azure"></i>
            </div>
            <div>Edit Warna Bibir
                <div class="page-title-subheading">Form untuk mengedit warna bibir.</div>
            </div>
        </div>
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">
        <form action="<?= base_url('masterwarnabibir/update/'.$warnabibir['id']) ?>" method="post">
            <div class="form-group">
                <label for="name">Nama Warna Bibir</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= esc($warnabibir['name']) ?>" required>
            </div>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= base_url('masterwarnabibir') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>
