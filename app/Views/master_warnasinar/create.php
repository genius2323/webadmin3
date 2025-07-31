<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <h4 class="mb-4">Tambah Warna Sinar</h4>
    <form action="<?= base_url('masterwarnasinar/save') ?>" method="post">
        <div class="form-group">
            <label for="name">Nama Warna Sinar</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('masterwarnasinar') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?= $this->endSection(); ?>
