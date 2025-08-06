<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<style>
    .select2-container .select2-selection--single {
        height: 38px;
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
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

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="archive"></i></div>
                            Edit Master Barang
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
                        <form action="<?= site_url('masterbarang/update/' . $barang['id']) ?>" method="post" autocomplete="off">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control" required placeholder="Nama Barang" value="<?= esc($barang['name']) ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                        <select name="category_id" id="category_id" class="form-select" required>
                                            <option value="">- Pilih Kategori -</option>
                                            <?php foreach ($categoryList as $cat): ?>
                                                <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $barang['category_id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="satuan_id" class="form-label">Satuan <span class="text-danger">*</span></label>
                                        <select name="satuan_id" id="satuan_id" class="form-select" required>
                                            <option value="">- Pilih Satuan -</option>
                                            <?php foreach ($satuanList as $sat): ?>
                                                <option value="<?= $sat['id'] ?>" <?= $sat['id'] == $barang['satuan_id'] ? 'selected' : '' ?>><?= esc($sat['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_id" class="form-label">Jenis <span class="text-danger">*</span></label>
                                        <select name="jenis_id" id="jenis_id" class="form-select" required>
                                            <option value="">- Pilih Jenis -</option>
                                            <?php foreach ($jenisList as $jen): ?>
                                                <option value="<?= $jen['id'] ?>" <?= $jen['id'] == $barang['jenis_id'] ? 'selected' : '' ?>><?= esc($jen['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                                        <input type="text" name="price" id="price" class="form-control" required pattern="^Rp\s\d{1,3}(\.\d{3})*$" inputmode="numeric" autocomplete="off" placeholder="Rp 0" value="<?= 'Rp ' . number_format((float)$barang['price'], 0, ',', '.') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                                        <input type="number" name="stock" id="stock" class="form-control" required min="0" placeholder="Stok Barang" value="<?= esc($barang['stock']) ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-info mb-3">
                                        <div class="card-header bg-info text-white">Master Klasifikasi Lainnya</div>
                                        <div class="card-body">
                                            <?php $klasifikasi = [
                                                'pelengkap' => 'Pelengkap',
                                                'gondola' => 'Gondola',
                                                'merk' => 'Merk',
                                                'warna_sinar' => 'Warna Sinar',
                                                'ukuran_barang' => 'Ukuran Barang',
                                                'voltase' => 'Voltase',
                                                'dimensi' => 'Dimensi',
                                                'warna_body' => 'Warna Body',
                                                'warna_bibir' => 'Warna Bibir',
                                                'kaki' => 'Kaki',
                                                'model' => 'Model',
                                                'fiting' => 'Fiting',
                                                'daya' => 'Daya',
                                                'jumlah_mata' => 'Jumlah Mata',
                                            ];
                                            foreach ($klasifikasi as $key => $label): ?>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input toggle-klasifikasi" type="checkbox" value="1" id="cb-<?= $key ?>" <?= !empty($barang[$key . '_id']) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="cb-<?= $key ?>">Tambah <?= $label ?></label>
                                                </div>
                                                <div class="mb-3<?= empty($barang[$key . '_id']) ? ' d-none' : '' ?>" id="box-<?= $key ?>">
                                                    <label for="<?= $key ?>_id" class="form-label"><?= $label ?></label>
                                                    <select class="form-select" id="<?= $key ?>_id" name="<?= $key ?>_id">
                                                        <option value="">- Pilih <?= $label ?> -</option>
                                                        <?php foreach ($klasifikasiData[$key] as $item): ?>
                                                            <option value="<?= $item['id'] ?>" <?= $item['id'] == $barang[$key . '_id'] ? 'selected' : '' ?>><?= esc($item['name']) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i data-feather="save" class="me-1"></i> Simpan Perubahan
                                </button>
                                <a href="<?= site_url('masterbarang') ?>" class="btn btn-danger ms-2">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<script>
    if (window.feather) feather.replace();
    $(function() {
        $('.form-select').select2({
            theme: 'default',
            width: '100%',
            placeholder: function() {
                return $(this).attr('placeholder') || 'Pilih';
            },
            allowClear: true
        });
        $('.toggle-klasifikasi').off('change').on('change', function() {
            var key = $(this).attr('id').replace('cb-', '');
            var $box = $('#box-' + key);
            if ($(this).is(':checked')) {
                $box.removeClass('d-none');
            } else {
                $box.addClass('d-none');
                $box.find('select').val('').trigger('change');
            }
        });
    });

    // Native JS input masking for price field
    const priceInput = document.getElementById('price');
    if (priceInput) {
        priceInput.addEventListener('input', function(e) {
            let value = this.value.replace(/[^\d]/g, '');
            if (value === '') {
                this.value = 'Rp 0';
                return;
            }
            let formatted = '';
            let rev = value.split('').reverse().join('');
            for (let i = 0; i < rev.length; i++) {
                if (i > 0 && i % 3 === 0) formatted = '.' + formatted;
                formatted = rev[i] + formatted;
            }
            this.value = 'Rp ' + formatted;
        });
        priceInput.addEventListener('focus', function() {
            if (this.value === '') this.value = 'Rp 0';
        });
        priceInput.addEventListener('blur', function() {
            if (this.value === '' || this.value === 'Rp') this.value = 'Rp 0';
        });
        // Convert to plain number on submit
        priceInput.form.addEventListener('submit', function(e) {
            let val = priceInput.value.replace(/[^\d]/g, '');
            priceInput.value = val;
        });
    }
</script>
<?= $this->endSection() ?>