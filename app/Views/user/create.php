<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                            Tambah User
                        </h1>
                        <div class="small">Form untuk menambah user baru dan memilih banyak departemen.</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid px-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-4 animate__animated animate__fadeInUp">
                    <div class="card-body">
                        <?php if (session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i data-feather="check-circle" class="me-1"></i>
                                <?= session('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <form action="<?= site_url('user/store') ?>" method="post" autocomplete="off">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                        <input type="text" name="nama" id="nama" class="form-control" required placeholder="Nama User">
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                        <input type="text" name="username" id="username" class="form-control" required placeholder="Username">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" id="password" class="form-control" required placeholder="Password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="noktp" class="form-label">No KTP <span class="text-danger">*</span></label>
                                        <input type="text" name="noktp" id="noktp" class="form-control" required placeholder="No KTP">
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                        <input type="text" name="alamat" id="alamat" class="form-control" required placeholder="Alamat">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pilih Departemen <span class="text-danger">*</span></label>
                                        <div class="switch-group-modern">
                                            <?php foreach ($departments as $dept): ?>
                                                <label class="switch-modern">
                                                    <input type="checkbox" name="departments[]" value="<?= $dept['id'] ?>">
                                                    <span class="slider-modern"></span>
                                                    <span class="switch-label-modern"><?= esc(isset($dept['nama']) ? $dept['nama'] : $dept['name']) ?></span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                        <small class="form-text text-muted">Pilih satu atau lebih departemen dengan tombol on/off.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i data-feather="save" class="me-1"></i> Simpan User
                                </button>
                                <a href="<?= site_url('user') ?>" class="btn btn-danger ms-2">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function() {
        if (window.feather) feather.replace();
    });
</script>
<?= $this->endSection() ?>
<style>
    .input-modern {
        border: 1px solid #e9edf5;
        border-radius: 8px;
        padding: 0.7em 1em;
        font-size: 1em;
        background: #f4f7fa;
        transition: border 0.18s;
    }

    .input-modern:focus {
        border: 1.5px solid #4fc3f7;
        outline: none;
        background: #fff;
    }

    .switch-group-modern {
        display: flex;
        flex-wrap: wrap;
        gap: 1em;
    }

    .switch-modern {
        display: flex;
        align-items: center;
        gap: 0.5em;
        margin-bottom: 0.5em;
    }

    .switch-modern input[type="checkbox"] {
        display: none;
    }

    .slider-modern {
        width: 40px;
        height: 22px;
        background: #e4e4e4;
        border-radius: 22px;
        position: relative;
        transition: background 0.3s;
        cursor: pointer;
    }

    .switch-modern input[type="checkbox"]:checked+.slider-modern {
        background: #0d6efd;
    }

    .slider-modern:before {
        content: '';
        position: absolute;
        left: 3px;
        top: 3px;
        width: 16px;
        height: 16px;
        background: #fff;
        border-radius: 50%;
        transition: left 0.3s;
    }

    .switch-modern input[type="checkbox"]:checked+.slider-modern:before {
        left: 21px;
    }

    .switch-label-modern {
        font-size: 1em;
        color: #333;
    }

    .btn-secondary-modern {
        background: #e9edf5;
        color: #232946;
    }

    .btn-secondary-modern:hover {
        background: #d1d8e0;
        color: #232946;
    }

    @media (max-width: 768px) {
        .card-modern {
            padding: 1.2rem 0.7rem 1rem 0.7rem;
        }

        .main-content {
            padding: 1rem 0.2rem 1rem 0.2rem;
        }
    }
</style>