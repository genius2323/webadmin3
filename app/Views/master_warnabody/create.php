<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <h4 class="mb-4">Tambah Warna Body</h4>
    <form action="<?= base_url('masterwarnabody/save') ?>" method="post">
        <div class="form-group">
            <label for="name">Nama Warna Body</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('masterwarnabody') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?= $this->endSection(); ?>
