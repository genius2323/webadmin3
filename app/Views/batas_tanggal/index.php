<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="calendar"></i></div>
                            Batas Tanggal Sistem
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid px-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card animate__animated animate__fadeInUp mb-4">
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
                                        <input class="form-check-input d-none" type="radio" name="mode" id="modeManual" value="manual" <?= ($batas['mode_batas_tanggal'] ?? 'manual') == 'manual' ? 'checked' : '' ?> />
                                        <label for="modeManual" class="card p-3 h-100 w-100 sbadmin-radio-btn <?= ($batas['mode_batas_tanggal'] ?? 'manual') == 'manual' ? 'border-primary shadow border-2' : '' ?>" style="cursor:pointer; user-select:none;">
                                            <i data-feather="edit-3" class="me-1"></i> Manual<br>
                                            <small class="text-muted">Atur Batas Tanggal</small>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <input class="form-check-input d-none" type="radio" name="mode" id="modeAuto" value="automatic" <?= ($batas['mode_batas_tanggal'] ?? '') == 'automatic' ? 'checked' : '' ?> />
                                        <label for="modeAuto" class="card p-3 h-100 w-100 sbadmin-radio-btn <?= ($batas['mode_batas_tanggal'] ?? '') == 'automatic' ? 'border-primary shadow border-2' : '' ?>" style="cursor:pointer; user-select:none;">
                                            <i data-feather="refresh-cw" class="me-1"></i> Otomatis<br>
                                            <small class="text-muted">H-2</small>
                                        </label>
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
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i data-feather="save" class="me-1"></i> Simpan Pengaturan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .sbadmin-radio-btn {
        border: 1.5px solid #dee2e6;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .sbadmin-radio-btn.border-primary {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .15);
    }

    .form-check-input.d-none {
        display: none !important;
    }
</style>
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
            // Toggle active class on card
            document.querySelectorAll('.sbadmin-radio-btn').forEach(function(card) {
                card.classList.remove('border-primary', 'shadow', 'border-2');
            });
            if (manual.checked) {
                document.querySelector('label[for="modeManual"]').classList.add('border-primary', 'shadow', 'border-2');
            } else {
                document.querySelector('label[for="modeAuto"]').classList.add('border-primary', 'shadow', 'border-2');
            }
        }
        document.getElementById('modeManual').addEventListener('change', toggleTanggalBatas);
        document.getElementById('modeAuto').addEventListener('change', toggleTanggalBatas);
        // In case user clicks the card directly (not just the radio)
        document.querySelectorAll('.sbadmin-radio-btn').forEach(function(card) {
            card.addEventListener('click', function() {
                setTimeout(toggleTanggalBatas, 10);
            });
        });
        toggleTanggalBatas();
        if (window.feather) feather.replace();
    });
</script>
<?= $this->endSection() ?>