<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container mt-4">
    <h2 class="mb-3">Tambah Setting Discount</h2>
    <form method="post" action="<?= site_url('discountsettings/create') ?>">
        <div class="mb-3">
            <label for="discount_type" class="form-label">Jenis Discount</label>
            <select name="discount_type" id="discount_type" class="form-select" required onchange="showFields()">
                <option value="nominal">Nominal Barang</option>
                <option value="persen">Persen Barang</option>
                <option value="bertingkat">Bertingkat Barang</option>
                <option value="customer">Customer Type</option>
                <option value="nota">Nota</option>
            </select>
        </div>
        <div id="field_nominal" class="mb-3">
            <label for="value_nominal" class="form-label">Nominal Discount (Rp)</label>
            <input type="number" name="value_nominal" id="value_nominal" class="form-control">
        </div>
        <div id="field_persen" class="mb-3" style="display:none;">
            <label for="value_percent" class="form-label">Persen Discount (%)</label>
            <input type="number" step="0.01" name="value_percent" id="value_percent" class="form-control">
        </div>
        <div id="field_bertingkat" class="mb-3" style="display:none;">
            <label for="tier_json" class="form-label">Discount Bertingkat (JSON)</label>
            <input type="text" name="tier_json" id="tier_json" class="form-control" placeholder='Contoh: [{"percent":10},{"percent":5}]'>
        </div>
        <div id="field_customer" class="mb-3" style="display:none;">
            <label for="customer_type" class="form-label">Jenis Customer</label>
            <select name="customer_type" id="customer_type" class="form-select">
                <option value="distributor">Distributor</option>
                <option value="agent">Agent</option>
                <option value="suplier">Suplier</option>
                <option value="retail">Retail</option>
            </select>
            <label for="value_percent_customer" class="form-label mt-2">Persen Discount (%)</label>
            <input type="number" step="0.01" name="value_percent" id="value_percent_customer" class="form-control">
            <label for="value_nominal_customer" class="form-label mt-2">Nominal Discount (Rp)</label>
            <input type="number" name="value_nominal" id="value_nominal_customer" class="form-control">
        </div>
        <div id="field_nota" class="mb-3" style="display:none;">
            <label for="nota_percent" class="form-label">Persen Discount Nota (%)</label>
            <input type="number" step="0.01" name="nota_percent" id="nota_percent" class="form-control">
            <label for="nota_nominal" class="form-label mt-2">Nominal Discount Nota (Rp)</label>
            <input type="number" name="nota_nominal" id="nota_nominal" class="form-control">
        </div>
        <div class="mb-3">
            <label for="active" class="form-label">Aktifkan Setting Ini?</label>
            <input type="checkbox" name="active" id="active" value="1">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= site_url('discountsettings') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script>
    function showFields() {
        var type = document.getElementById('discount_type').value;
        document.getElementById('field_nominal').style.display = (type === 'nominal') ? '' : 'none';
        document.getElementById('field_persen').style.display = (type === 'persen') ? '' : 'none';
        document.getElementById('field_bertingkat').style.display = (type === 'bertingkat') ? '' : 'none';
        document.getElementById('field_customer').style.display = (type === 'customer') ? '' : 'none';
        document.getElementById('field_nota').style.display = (type === 'nota') ? '' : 'none';
    }
    document.addEventListener('DOMContentLoaded', showFields);
</script>
<?= $this->endSection(); ?>