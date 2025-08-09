<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<style>
    .select2-container .select2-selection--single {
        height: 38px;
        padding: 6px 12px;
        border: 1.5px solid #dee2e6;
        border-radius: 8px;
        background: #fff;
        font-size: 1em;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #495057;
        line-height: 24px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
        right: 10px;
    }
</style>
<main class="animate__animated animate__fadeIn">
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="archive"></i></div>
                            Tambah Master Sales
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid px-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card mb-4 animate__animated animate__fadeInUp">
                    <div class="card-body">
                        <?php if (session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i data-feather="check-circle" class="me-1"></i>
                                <?= session('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <form action="<?= site_url('mastersales/save') ?>" method="post" autocomplete="off">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kode" class="form-label">Kode <span class="text-danger">*</span></label>
                                        <input type="text" name="kode" id="kode" class="form-control" required placeholder="Kode Sales">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                        <input type="text" name="nama" id="nama" class="form-control" required placeholder="Nama Sales">
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat Sales">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Tempat Lahir">
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_hp" class="form-label">No HP</label>
                                        <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="No HP">
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_ktp" class="form-label">No KTP</label>
                                        <input type="text" name="no_ktp" id="no_ktp" class="form-control" placeholder="No KTP">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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
                            <button type="submit" class="btn btn-primary"><i data-feather="save"></i> Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>