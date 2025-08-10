<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 mb-4 animate__animated animate__fadeInDown">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-cash-register me-2"></i>
                    <h5 class="mb-0" style="color: white;">Input Nota Baru (POS)</h5>
                </div>
                <div class="card-body">
                    <form id="form-pos" method="post" action="<?= site_url('penjualan/posBooking') ?>">
                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Nomor Nota</label>
                                <input type="text" name="nomor_nota" class="form-control" required autocomplete="off">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal_nota" class="form-control" required id="tanggalNota">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Sales</label>
                                <select name="sales_id" class="form-select" required>
                                    <option value="">Pilih Sales</option>
                                    <?php foreach ($salesList as $sales): ?>
                                        <option value="<?= $sales['id'] ?>"><?= esc($sales['nama']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Customer</label>
                                <select name="customer_id" class="form-select" required>
                                    <option value="">Pilih Customer</option>
                                    <?php foreach ($customerList as $cust): ?>
                                        <option value="<?= $cust['id'] ?>"><?= esc($cust['nama_customer']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Metode Pembayaran</label>
                                <select name="metode_bayar" class="form-select" required id="metodeBayar">
                                    <option value="">Pilih Metode</option>
                                    <option value="Tunai">Tunai</option>
                                    <option value="Kredit">Kredit</option>
                                </select>
                            </div>
                            <!-- Kolom Jenis Tunai dihapus karena tidak diperlukan dan tidak ada di tabel sales -->
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Tambah Barang</label>
                            <div class="input-group">
                                <select class="form-select" id="barangSelect">
                                    <option value="">Pilih Barang</option>
                                    <?php foreach ($barangList as $barang): ?>
                                        <option value='<?= json_encode($barang) ?>'><?= esc($barang['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="number" min="1" class="form-control" id="qtyInput" placeholder="Qty" style="max-width:90px;">
                                <button type="button" class="btn btn-success" id="addBarangBtn"><i class="fas fa-plus"></i> Tambah</button>
                            </div>
                        </div>
                        <div class="table-responsive mb-3 animate__animated animate__fadeInUp">
                            <table class="table table-bordered align-middle" id="tableBarang">
                                <thead class="table-light">
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Nama Barang</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Item akan di-generate JS -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-end">Total</th>
                                        <th id="grandTotal">Rp 0</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg animate__animated animate__pulse animate__infinite">Simpan & Booking Nota</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// SBAdmin animasi dan interaksi POS
const metodeBayar = document.getElementById('metodeBayar');
const opsiTunai = document.getElementById('opsiTunai');
if(metodeBayar) {
    metodeBayar.addEventListener('change', function() {
        if(this.value === 'Tunai') opsiTunai.classList.remove('d-none');
        else opsiTunai.classList.add('d-none');
    });
}
// Barang table interaktif
let barangList = <?php echo json_encode($barangList); ?>;
let tableBody = document.querySelector('#tableBarang tbody');
let grandTotal = 0;
function updateGrandTotal() {
    let total = 0;
    tableBody.querySelectorAll('tr').forEach(tr => {
        total += parseInt(tr.querySelector('.subtotal').dataset.value || 0);
    });
    document.getElementById('grandTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
}
document.getElementById('addBarangBtn').onclick = function() {
    let barangData = document.getElementById('barangSelect').value;
    let qty = parseInt(document.getElementById('qtyInput').value);
    if(!barangData || !qty || qty < 1) return;
    let barang = JSON.parse(barangData);
    let subtotal = barang.price * qty;
    let row = document.createElement('tr');
    row.innerHTML = `<td><img src='${barang.image_url || '/public/assets/img/no-image.png'}' style='width:40px;height:40px;object-fit:cover;border-radius:6px;'></td>
        <td>${barang.name}</td>
        <td>Rp ${parseInt(barang.price).toLocaleString('id-ID')}</td>
        <td>${qty}<input type='hidden' name='barang_id[]' value='${barang.id}'><input type='hidden' name='qty[]' value='${qty}'></td>
        <td class='subtotal' data-value='${subtotal}'>Rp ${subtotal.toLocaleString('id-ID')}</td>
        <td><button type='button' class='btn btn-danger btn-sm btn-hapus-barang'><i class='fas fa-trash'></i></button></td>`;
    row.querySelector('.btn-hapus-barang').onclick = function() {
        row.remove();
        updateGrandTotal();
    };
    tableBody.appendChild(row);
    updateGrandTotal();
};
// Validasi tanggal dengan batas tanggal
const tanggalNota = document.getElementById('tanggalNota');
<?php if (isset($batasTanggal)): ?>
    tanggalNota.setAttribute('min', '<?= $batasTanggal['min'] ?>');
    tanggalNota.setAttribute('max', '<?= $batasTanggal['max'] ?>');
<?php endif; ?>
</script>
<?= $this->endSection(); ?>
