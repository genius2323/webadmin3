<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="page-header-modern">
    <div>
        <h2 class="page-title">Tambah User</h2>
        <div class="page-subtitle">Form untuk menambah user baru dan memilih banyak departemen.</div>
    </div>
</div>
<div class="card-modern">
    <form action="<?= site_url('user/store') ?>" method="post">
        <div class="form-group-modern">
            <label>Nama</label>
            <input type="text" name="nama" class="input-modern" required>
        </div>
        <div class="form-group-modern">
            <label>Username</label>
            <input type="text" name="username" class="input-modern" required>
        </div>
        <div class="form-group-modern">
            <label>Password</label>
            <input type="password" name="password" class="input-modern" required>
        </div>
        <div class="form-group-modern">
            <label>No KTP</label>
            <input type="text" name="noktp" class="input-modern" required>
        </div>
        <div class="form-group-modern">
            <label>Alamat</label>
            <input type="text" name="alamat" class="input-modern" required>
        </div>
        <div class="form-group-modern">
            <label>Pilih Departemen</label>
            <div class="switch-group-modern">
                <?php foreach ($departments as $dept): ?>
                    <label class="switch-modern">
                        <input type="checkbox" name="departments[]" value="<?= $dept['id'] ?>">
                        <span class="slider-modern"></span>
                        <span class="switch-label-modern"><?= esc(isset($dept['nama']) ? $dept['nama'] : $dept['name']) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
            <small class="form-text-modern">Pilih Satu atau Lebih Departemen</small>
        </div>
        <div class="form-group-modern text-right">
            <button type="submit" class="btn-modern btn-primary-modern"><svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5v14" stroke="#fff" stroke-width="2" stroke-linecap="round" />
                </svg> Simpan</button>
            <a href="<?= site_url('user') ?>" class="btn-modern btn-secondary-modern">Kembali</a>
        </div>
    </form>
</div>
<style>
    .form-group-modern {
        margin-bottom: 1.3em;
        display: flex;
        flex-direction: column;
        gap: 0.3em;
    }

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
        gap: 1.2em 1.5em;
        margin-top: 0.3em;
    }

    .switch-modern {
        display: flex;
        align-items: center;
        gap: 0.5em;
        font-size: 1em;
        font-weight: 500;
    }

    .switch-modern input[type="checkbox"] {
        display: none;
    }

    .slider-modern {
        width: 36px;
        height: 20px;
        background: #e9edf5;
        border-radius: 12px;
        position: relative;
        transition: background 0.18s;
        cursor: pointer;
        margin-right: 0.2em;
    }

    .slider-modern:before {
        content: '';
        position: absolute;
        left: 3px;
        top: 3px;
        width: 14px;
        height: 14px;
        background: #fff;
        border-radius: 50%;
        transition: transform 0.18s;
        box-shadow: 0 1px 4px 0 rgba(44, 62, 80, 0.08);
    }

    .switch-modern input[type="checkbox"]:checked+.slider-modern {
        background: #4fc3f7;
    }

    .switch-modern input[type="checkbox"]:checked+.slider-modern:before {
        transform: translateX(16px);
        background: #232946;
    }

    .switch-label-modern {
        margin-left: 0.2em;
    }

    .form-text-modern {
        color: #6c7a89;
        font-size: 0.97em;
        margin-top: 0.2em;
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
<?= $this->endSection() ?>