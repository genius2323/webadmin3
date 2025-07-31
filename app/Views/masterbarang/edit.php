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
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="fa fa-cube"></i>
            </div>
            <div>Edit Barang
                <div class="page-title-subheading">Form untuk mengedit data barang.</div>
            </div>
        </div>
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">
        <form action="<?= site_url('masterbarang/update/'.$barang['id']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-7">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= esc($barang['name']) ?>" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">- Pilih Kategori -</option>
                            <?php foreach ($categoryList as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= $cat['id']==$barang['category_id']?'selected':'' ?>><?= esc($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="satuan_id" class="form-label">Satuan</label>
                        <select class="form-select" id="satuan_id" name="satuan_id">
                            <option value="">- Pilih Satuan -</option>
                            <?php foreach ($satuanList as $sat): ?>
                                <option value="<?= $sat['id'] ?>" <?= $sat['id']==$barang['satuan_id']?'selected':'' ?>><?= esc($sat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_id" class="form-label">Jenis</label>
                        <select class="form-select" id="jenis_id" name="jenis_id">
                            <option value="">- Pilih Jenis -</option>
                            <?php foreach ($jenisList as $jen): ?>
                                <option value="<?= $jen['id'] ?>" <?= $jen['id']==$barang['jenis_id']?'selected':'' ?>><?= esc($jen['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" maxlength="20" inputmode="decimal" pattern="[0-9]*[.,]?[0-9]*" value="<?= esc($barang['price']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stock" name="stock" min="0" value="<?= esc($barang['stock']) ?>" required>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card border-info mb-3">
                        <div class="card-header bg-info text-white">Master Klasifikasi Lainnya</div>
                        <div class="card-body">
                            <?php foreach ($klasifikasi as $key => $label): ?>
                            <div class="form-check mb-2">
                                <input class="form-check-input toggle-klasifikasi" type="checkbox" value="1" id="cb-<?= $key ?>" <?= !empty($barang[$key.'_id']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="cb-<?= $key ?>">Tambah <?= $label ?></label>
                            </div>
                            <div class="mb-3<?= empty($barang[$key.'_id']) ? ' d-none' : '' ?>" id="box-<?= $key ?>">
                                <label for="<?= $key ?>_id" class="form-label"><?= $label ?></label>
                                <select class="form-select" id="<?= $key ?>_id" name="<?= $key ?>_id">
                                    <option value="">- Pilih <?= $label ?> -</option>
                                    <?php foreach ($klasifikasiData[$key] as $item): ?>
                                        <option value="<?= $item['id'] ?>" <?= $item['id']==$barang[$key.'_id']?'selected':'' ?>><?= esc($item['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3 d-flex gap-2 justify-content-start">
                    <button type="submit" class="align-items-center btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?= site_url('masterbarang') ?>" class="btn btn-secondary align-items-center">Kembali</a>
                </div>
            </div>
        </form>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
        $(function(){
            $('.form-select').select2({
                theme: 'default',
                width: '100%',
                placeholder: function(){
                    return $(this).attr('placeholder') || 'Pilih';
                },
                allowClear: true
            });
            $('.toggle-klasifikasi').on('change', function(){
                var key = $(this).attr('id').replace('cb-','');
                if($(this).is(':checked')){
                    $('#box-'+key).removeClass('d-none');
                }else{
                    $('#box-'+key).addClass('d-none');
                    $('#box-'+key+' select').val('').trigger('change');
                }
            });
        });
        </script>
    </div>
</div>
<?= $this->endSection() ?>
