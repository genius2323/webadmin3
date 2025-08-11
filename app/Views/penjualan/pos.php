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
                                <label class="form-label">Customer</label>
                                <div class="input-group">
                                    <input type="text" id="customerName" class="form-control" placeholder="Pilih Customer" readonly required>
                                    <input type="hidden" name="customer_id" id="customerId" required>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalCustomer"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Sales</label>
                                <div class="input-group">
                                    <input type="text" id="salesName" class="form-control" placeholder="Pilih Sales" readonly required>
                                    <input type="hidden" name="sales_id" id="salesId" required>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalSales"><i class="fas fa-search"></i></button>
                                </div>
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
                                <input type="text" id="barangName" class="form-control" placeholder="Pilih Barang" readonly>
                                <input type="hidden" id="barangId">
                                <input type="number" min="1" class="form-control" id="qtyInput" placeholder="Qty" style="max-width:90px;">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalBarang"><i class="fas fa-search"></i></button>
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
<!-- Modal Customer -->
<div class="modal fade" id="modalCustomer" tabindex="-1" aria-labelledby="modalCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCustomerLabel">Pilih Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control mb-2" id="searchCustomer" placeholder="Cari customer...">
                <div class="table-responsive" style="max-height:400px;overflow-y:auto;">
                    <table class="table table-bordered table-hover align-middle" id="tableCustomer">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customerList as $cust): ?>
                                <tr>
                                    <td><?= esc($cust['nama_customer']) ?></td>
                                    <td><?= esc($cust['alamat']) ?></td>
                                    <td><button type="button" class="btn btn-sm btn-primary pilih-customer" data-id="<?= $cust['id'] ?>" data-nama="<?= esc($cust['nama_customer']) ?>" data-sales-id="<?= esc($cust['sales_id'] ?? '') ?>" data-sales-nama="<?= esc($cust['sales_nama'] ?? '') ?>">Pilih</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Sales -->
<div class="modal fade" id="modalSales" tabindex="-1" aria-labelledby="modalSalesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSalesLabel">Pilih Sales</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control mb-2" id="searchSales" placeholder="Cari sales...">
                <div class="table-responsive" style="max-height:400px;overflow-y:auto;">
                    <table class="table table-bordered table-hover align-middle" id="tableSales">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($salesList as $sales): ?>
                                <tr>
                                    <td><?= esc($sales['nama']) ?></td>
                                    <td><?= esc($sales['status']) ?></td>
                                    <td><button type="button" class="btn btn-sm btn-primary pilih-sales" data-id="<?= $sales['id'] ?>" data-nama="<?= esc($sales['nama']) ?>">Pilih</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Barang -->
<div class="modal fade" id="modalBarang" tabindex="-1" aria-labelledby="modalBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBarangLabel">Pilih Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control mb-2" id="searchBarang" placeholder="Cari barang...">
                <div class="table-responsive" style="max-height:400px;overflow-y:auto;">
                    <table class="table table-bordered table-hover align-middle" id="tableBarangModal">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($barangList as $barang): ?>
                                <tr>
                                    <td><?= esc($barang['name']) ?></td>
                                    <td>Rp <?= number_format($barang['price'], 0, ',', '.') ?></td>
                                    <td><button type="button" class="btn btn-sm btn-primary pilih-barang" data-id="<?= $barang['id'] ?>" data-nama="<?= esc($barang['name']) ?>" data-harga="<?= $barang['price'] ?>">Pilih</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Modal interaksi customer
    document.querySelectorAll('.pilih-customer').forEach(btn => {
        btn.onclick = function() {
            document.getElementById('customerId').value = this.dataset.id;
            document.getElementById('customerName').value = this.dataset.nama;
            // Jika customer punya sales, isi otomatis
            if (this.dataset.salesId) {
                document.getElementById('salesId').value = this.dataset.salesId;
                // Cari nama sales dari salesList
                let salesNama = '';
                let salesList = <?php echo json_encode($salesList); ?>;
                for (let s of salesList) {
                    if (s.id == this.dataset.salesId) {
                        salesNama = s.nama;
                        break;
                    }
                }
                document.getElementById('salesName').value = salesNama;
            } else {
                document.getElementById('salesId').value = '';
                document.getElementById('salesName').value = '';
            }
            var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalCustomer'));
            modal.hide();
        };
    });
    document.getElementById('searchCustomer').oninput = function() {
        let val = this.value.toLowerCase();
        document.querySelectorAll('#tableCustomer tbody tr').forEach(tr => {
            let nama = tr.children[0].innerText.toLowerCase();
            let alamat = tr.children[1].innerText.toLowerCase();
            tr.style.display = (nama.includes(val) || alamat.includes(val)) ? '' : 'none';
        });
    };
    // Modal interaksi sales
    document.querySelectorAll('.pilih-sales').forEach(btn => {
        btn.onclick = function() {
            document.getElementById('salesId').value = this.dataset.id;
            document.getElementById('salesName').value = this.dataset.nama;
            var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalSales'));
            modal.hide();
        };
    });
    document.getElementById('searchSales').oninput = function() {
        let val = this.value.toLowerCase();
        document.querySelectorAll('#tableSales tbody tr').forEach(tr => {
            let nama = tr.children[0].innerText.toLowerCase();
            let status = tr.children[1].innerText.toLowerCase();
            tr.style.display = (nama.includes(val) || status.includes(val)) ? '' : 'none';
        });
    };
    // Modal interaksi barang
    document.querySelectorAll('.pilih-barang').forEach(btn => {
        btn.onclick = function() {
            document.getElementById('barangId').value = this.dataset.id;
            document.getElementById('barangName').value = this.dataset.nama;
            document.getElementById('qtyInput').focus();
            var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalBarang'));
            modal.hide();
        };
    });
    document.getElementById('searchBarang').oninput = function() {
        let val = this.value.toLowerCase();
        document.querySelectorAll('#tableBarangModal tbody tr').forEach(tr => {
            let nama = tr.children[0].innerText.toLowerCase();
            let harga = tr.children[1].innerText.toLowerCase();
            tr.style.display = (nama.includes(val) || harga.includes(val)) ? '' : 'none';
        });
    };
    // SBAdmin animasi dan interaksi POS
    const metodeBayar = document.getElementById('metodeBayar');
    const opsiTunai = document.getElementById('opsiTunai');
    if (metodeBayar) {
        metodeBayar.addEventListener('change', function() {
            if (this.value === 'Tunai') opsiTunai.classList.remove('d-none');
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
        if (!barangData || !qty || qty < 1) return;
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