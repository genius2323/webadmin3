<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<header class="py-10 mb-4 bg-gradient-primary-to-secondary">
    <div class="container-xl px-4">
        <div class="text-center">
            <h1 class="text-white">Batas Tanggal Sistem</h1>
            <p class="lead mb-0 text-white-50">Tingkatkan keamanan dengan mengatur batas waktu input transaksi.</p>
        </div>
    </div>
</header>
<div class="container-xl px-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <?php if (session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i data-feather="check-circle" class="me-1"></i>
                            <?= session('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form action="<?= site_url('batas-tanggal/update') ?>" method="post" autocomplete="off">
                        <input type="hidden" name="id" value="<?= esc($batas['id'] ?? '') ?>">
                        <div class="mb-3">
                            <label for="menu" class="form-label">Pilih Menu Transaksi <span class="text-danger">*</span></label>
                            <select name="menu" id="menu" class="form-select" required>
                                <option value="" disabled <?= empty($batas['menu']) ? 'selected' : '' ?>>-- Pilih Menu --</option>
                                <option value="penjualan" <?= ($batas['menu'] ?? '') == 'penjualan' ? 'selected' : '' ?>>Penjualan</option>
                                <option value="pembelian" <?= ($batas['menu'] ?? '') == 'pembelian' ? 'selected' : '' ?>>Pembelian</option>
                                <option value="jurnal" <?= ($batas['menu'] ?? '') == 'jurnal' ? 'selected' : '' ?>>Jurnal</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pilih Mode Pengaturan</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="form-check card p-3 h-100 <?= ($batas['mode_batas_tanggal'] ?? 'manual') == 'manual' ? 'border-primary' : '' ?>" style="cursor:pointer;">
                                        <input class="form-check-input" type="radio" name="mode" id="modeManual" value="manual" <?= ($batas['mode_batas_tanggal'] ?? 'manual') == 'manual' ? 'checked' : '' ?> />
                                        <label class="form-check-label w-100" for="modeManual">
                                            <i data-feather="edit-3" class="me-1"></i> Manual<br>
                                            <small class="text-muted">Atur Batas Tanggal</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check card p-3 h-100 <?= ($batas['mode_batas_tanggal'] ?? '') == 'automatic' ? 'border-primary' : '' ?>" style="cursor:pointer;">
                                        <input class="form-check-input" type="radio" name="mode" id="modeAuto" value="automatic" <?= ($batas['mode_batas_tanggal'] ?? '') == 'automatic' ? 'checked' : '' ?> />
                                        <label class="form-check-label w-100" for="modeAuto">
                                            <i data-feather="refresh-cw" class="me-1"></i> Otomatis<br>
                                            <small class="text-muted">H-2</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3" id="tanggalBatasGroup">
                            <label for="batas_tanggal" class="form-label">Tanggal Batas <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="batas_tanggal" id="batas_tanggal" class="form-control" value="<?= isset($batas['batas_tanggal']) ? date('d/m/Y', strtotime($batas['batas_tanggal'])) : date('d/m/Y') ?>" required autocomplete="off" placeholder="Pilih tanggal batas">
                                <span class="input-group-text"><i data-feather="calendar"></i></span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="save" class="me-1"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('#batas_tanggal', {
            dateFormat: 'd/m/Y',
            disableMobile: true,
            allowInput: false
        });
        function toggleTanggalBatas() {
            var manual = document.getElementById('modeManual');
            var group = document.getElementById('tanggalBatasGroup');
            if (manual.checked) {
                group.style.display = '';
            } else {
                group.style.display = 'none';
            }
        }
        document.getElementById('modeManual').addEventListener('change', toggleTanggalBatas);
        document.getElementById('modeAuto').addEventListener('change', toggleTanggalBatas);
        toggleTanggalBatas();
        if (window.feather) feather.replace();
    });
</script>
<?= $this->endSection() ?>