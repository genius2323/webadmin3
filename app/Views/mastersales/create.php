<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-tempting-azure"></i>
            </div>
            <div>Tambah Sales / Pegawai
                <div class="page-title-subheading">Form untuk menambah data sales/pegawai baru.</div>
            </div>
        </div>
        <div class="page-title-actions">
            <a href="<?= site_url('mastersales') ?>" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
</div>
<div class="main-card mb-3 card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="<?= site_url('mastersales/save') ?>" method="post" autocomplete="off">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="kode" class="form-label">Kode <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="kode" name="kode" required>
                </div>
                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat">
                </div>
                <div class="col-md-6">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp">
                </div>
                <div class="col-md-6">
                    <label for="no_ktp" class="form-label">No KTP</label>
                    <input type="text" class="form-control" id="no_ktp" name="no_ktp">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label d-block">Status <span class="text-danger">*</span></label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="status_menikah" value="Menikah" required>
                        <label class="form-check-label" for="status_menikah">Menikah</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="status_belum" value="Belum Menikah" required>
                        <label class="form-check-label" for="status_belum">Belum Menikah</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
