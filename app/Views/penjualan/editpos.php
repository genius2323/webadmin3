<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="shopping-cart"></i></div>
                        Edit Nota Penjualan
                    </h1>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 mb-4 animate__animated animate__fadeInDown">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-cash-register me-2"></i>
                    <h5 class="mb-0" style="color: white;">Edit Nota Penjualan</h5>
                </div>
                <div class="card-body">
                    <form id="form-edit-pos" method="post" action="<?= site_url('penjualan/update/' . $penjualan['id']) ?>">
                        <input type="hidden" name="id" value="<?= esc($penjualan['id'] ?? '') ?>">
                        <input type="hidden" name="total" id="totalInput" value="<?= esc($penjualan['total'] ?? '') ?>">
                        <input type="hidden" name="grand_total" id="grandTotalInput" value="<?= esc($penjualan['grand_total'] ?? '') ?>">
                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Nomor Nota</label>
                                <input type="text" name="nomor_nota" class="form-control" value="<?= esc($penjualan['nomor_nota'] ?? '') ?>" readonly required autocomplete="off">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal</label>
                                <input type="text" name="tanggal_nota" id="tanggal_nota" class="form-control border-primary" style="background:#f8f9fa; cursor:pointer; color:#212529;" value="<?= isset($penjualan['tanggal_nota']) ? date('d/m/Y', strtotime($penjualan['tanggal_nota'])) : date('d/m/Y') ?>" required readonly>
                                <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                                <script>
                                    // Realtime update subtotal & grand total untuk qty yang sudah ada di tabel (edit)
                                    document.addEventListener('DOMContentLoaded', function() {
                                        document.querySelectorAll('#tableBarang input[name="qty[]"]').forEach(function(input) {
                                            input.addEventListener('input', function() {
                                                var tr = input.closest('tr');
                                                var harga = parseInt(tr.querySelector('.subtotal').dataset.value) / parseInt(input.value || 1);
                                                var jumlah = parseInt(input.value) || 1;
                                                if (!jumlah || jumlah < 1) input.value = 1;
                                                var subtotal = harga * jumlah;
                                                tr.querySelector('.subtotal').dataset.value = subtotal;
                                                tr.querySelector('.subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
                                                input.value = jumlah;
                                                updateGrandTotal();
                                            });
                                        });
                                        updateGrandTotal();
                                    });
                                    document.addEventListener('DOMContentLoaded', function() {
                                        flatpickr('#tanggal_nota', {
                                            dateFormat: 'd/m/Y',
                                            disableMobile: true,
                                            minDate: null,
                                            maxDate: null,
                                            allowInput: false
                                        });
                                    });
                                </script>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Customer</label>
                                <div class="input-group">
                                    <input type="text" id="customerName" class="form-control" placeholder="Pilih Customer" value="<?= esc($penjualan['customer_nama'] ?? '') ?>" readonly required>
                                    <input type="hidden" name="customer_id" id="customerId" value="<?= esc($penjualan['customer_id'] ?? '') ?>" required>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalCustomer"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Sales</label>
                                <div class="input-group">
                                    <input type="text" id="salesName" class="form-control" placeholder="Pilih Sales" value="<?= esc($penjualan['sales_nama'] ?? '') ?>" readonly required>
                                    <input type="hidden" name="sales_id" id="salesId" value="<?= esc($penjualan['sales_id'] ?? '') ?>" required>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalSales"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div id="kreditFields" class="row g-2 mb-2 d-none">
                                <div class="col-md-4">
                                    <label class="form-label">Tenor (bulan)</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">DP (Down Payment)</label>
                                    <input type="number" name="dp" class="form-control" min="0" placeholder="Contoh: 1000000" value="<?= esc($penjualan['dp'] ?? '') ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Catatan Kredit</label>
                                    <input type="text" name="catatan_kredit" class="form-control" placeholder="Opsional" value="<?= esc($penjualan['catatan_kredit'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive mb-3 animate__animated animate__fadeInUp">
                            <table class="table table-bordered align-middle" id="tableBarang">
                                <thead class="table-light">
                                    <tr>
                                        <th style="text-align:center;">Gambar</th>
                                        <th style="text-align:center;">Nama Barang</th>
                                        <th style="min-width:160px;text-align:center;">Harga</th>
                                        <th style="text-align:center;">Qty</th>
                                        <th style="min-width:160px;text-align:center;">Subtotal</th>
                                        <th style="text-align:center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($items)): ?>
                                        <?php foreach ($items as $item): ?>
                                            <tr data-barang-id="<?= esc($item['barang_id']) ?>">
                                                <td><img src="/public/assets/img/no-image.png" style="width:40px;height:40px;object-fit:cover;border-radius:6px;"></td>
                                                <td class="td-nama-barang"><?= esc($item['nama_barang']) ?></td>
                                                <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                                                <td><input type="number" name="qty[]" value="<?= esc($item['qty']) ?>" min="1" class="form-control form-control-sm jumlah-input" style="width:70px;display:inline-block;"><input type="hidden" name="barang_id[]" value="<?= esc($item['barang_id']) ?>"></td>
                                                <td class="subtotal" data-value="<?= esc($item['harga'] * $item['qty']) ?>" style="text-align:right;">Rp <?= number_format($item['harga'] * $item['qty'], 0, ',', '.') ?></td>
                                                <td><button type="button" class="btn btn-danger btn-sm btn-hapus-barang"><i class="fas fa-trash"></i></button></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-end">Total</th>
                                        <th id="grandTotal" style="text-align:right;">Rp <?= number_format($penjualan['grand_total'] ?? 0, 0, ',', '.') ?></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="mb-3">
                                <div class="input-group">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalBarang" id="btnPilihBarang">Pilih Barang</button>
                                </div>
                            </div>
                            <table class="table table-bordered align-middle">
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="text-end align-middle">Pembayaran</td>
                                        <td colspan="2" class="text-end align-middle">
                                            <input type="text" inputmode="numeric" class="form-control text-end" id="paymentAInput" name="payment_a" placeholder="Masukkan pembayaran customer" value="<?= number_format($penjualan['payment_a'] ?? 0, 0, ',', '.') ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="text-end align-middle">Status Pembayaran</td>
                                        <td colspan="2" class="text-end align-middle">
                                            <span id="badgeStatus" class="badge d-flex justify-content-center align-items-center" style="height:38px;min-width:90px;font-size:1rem;">
                                                <?= esc($penjualan['status_pembayaran'] ?? '') ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="text-end align-middle">Sisa Pelunasan</td>
                                        <td colspan="2" class="text-end align-middle">
                                            <span id="sisaPelunasan" class="fw-bold text-danger">Rp <?= number_format($penjualan['payment_b'] ?? 0, 0, ',', '.') ?></span>
                                        </td>
                                    </tr>
                                    <tr id="rowMetodeBayar" style="display:none;">
                                        <td colspan="6" class="text-end align-middle">Metode Pembayaran</td>
                                        <td colspan="2" class="align-middle">
                                            <select class="form-select" id="paymentSystemInput" name="payment_system">
                                                <option value="Tunai" <?= (isset($penjualan['payment_system']) && $penjualan['payment_system'] == 'Tunai') ? 'selected' : '' ?>>Tunai</option>
                                                <option value="Transfer" <?= (isset($penjualan['payment_system']) && $penjualan['payment_system'] == 'Transfer') ? 'selected' : '' ?>>Transfer</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr id="rowTenor" style="display:none;">
                                        <td colspan="6" class="text-end">Tenor (hari)</td>
                                        <td colspan="2">
                                            <input type="number" min="1" class="form-control" id="tenorInput" name="tenor" placeholder="Jumlah hari kredit" value="<?= esc($penjualan['tenor'] ?? '') ?>">
                                        </td>
                                    </tr>
                                    <tr id="rowJatuhTempo" style="display:none;">
                                        <td colspan="6" class="text-end">Tanggal Jatuh Tempo</td>
                                        <td colspan="2">
                                            <input type="text" class="form-control" id="jatuhTempoInput" name="jatuh_tempo" readonly value="<?= esc($penjualan['jatuh_tempo'] ?? '') ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg animate__animated animate__pulse animate__infinite">Update Nota</button>
                        </div>
                    </form>
                    <script>
                        // Format input pembayaran dengan Rp dan ribuan, simpan angka saja
                        const paymentAInput = document.getElementById('paymentAInput');
                        paymentAInput.addEventListener('input', function(e) {
                            let value = this.value.replace(/[^\d]/g, '');
                            if (value === '') value = '0';
                            this.value = parseInt(value).toLocaleString('id-ID');
                            document.getElementById('paymentAInputHidden').value = value;
                            updateSisaPelunasan();
                        });
                        // Hidden input untuk simpan angka
                        if (!document.getElementById('paymentAInputHidden')) {
                            const hidden = document.createElement('input');
                            hidden.type = 'hidden';
                            hidden.name = 'payment_a';
                            hidden.id = 'paymentAInputHidden';
                            hidden.value = paymentAInput.value.replace(/[^\d]/g, '');
                            paymentAInput.form.appendChild(hidden);
                        }
                        // Sisa Pelunasan dan payment_b
                        function updateSisaPelunasan() {
                            let pembayaran = parseInt(document.getElementById('paymentAInputHidden').value) || 0;
                            let grandTotal = parseInt(document.getElementById('grandTotalInput').value) || 0;
                            let sisa = grandTotal - pembayaran;
                            document.getElementById('sisaPelunasan').textContent = 'Rp ' + sisa.toLocaleString('id-ID');
                            // Simpan sisa ke payment_b
                            let paymentBInput = document.getElementById('paymentBInputHidden');
                            if (!paymentBInput) {
                                paymentBInput = document.createElement('input');
                                paymentBInput.type = 'hidden';
                                paymentBInput.name = 'payment_b';
                                paymentBInput.id = 'paymentBInputHidden';
                                paymentAInput.form.appendChild(paymentBInput);
                            }
                            paymentBInput.value = sisa;
                        }
                        paymentAInput.addEventListener('input', updateSisaPelunasan);
                        document.getElementById('grandTotalInput').addEventListener('input', updateSisaPelunasan);
                        updateSisaPelunasan();
                        // Helper ambil nilai tanggal nota
                        function getTanggalNotaYmd() {
                            let tgl = document.getElementById('tanggal_nota').value;
                            if (!tgl) return null;
                            let parts = tgl.split('/');
                            if (parts.length === 3) {
                                return parts[2] + '-' + parts[1].padStart(2, '0') + '-' + parts[0].padStart(2, '0');
                            }
                            return tgl;
                        }
                        // Update badge dan field pembayaran
                        function updatePaymentStatus() {
                            let paymentA = parseInt(document.getElementById('paymentAInputHidden').value) || 0;
                            let grandTotal = parseInt(document.getElementById('grandTotalInput').value) || 0;
                            let badge = document.getElementById('badgeStatus');
                            let rowMetode = document.getElementById('rowMetodeBayar');
                            let rowTenor = document.getElementById('rowTenor');
                            let rowJatuhTempo = document.getElementById('rowJatuhTempo');
                            if (paymentA >= grandTotal && grandTotal > 0) {
                                badge.textContent = 'LUNAS';
                                badge.className = 'badge bg-success d-flex justify-content-center align-items-center';
                                rowMetode.style.display = '';
                                rowTenor.style.display = 'none';
                                rowJatuhTempo.style.display = 'none';
                            } else if (paymentA > 0 && paymentA < grandTotal) {
                                badge.textContent = 'KREDIT';
                                badge.className = 'badge bg-warning text-dark d-flex justify-content-center align-items-center';
                                rowMetode.style.display = '';
                                rowTenor.style.display = '';
                                rowJatuhTempo.style.display = '';
                            } else {
                                badge.textContent = '';
                                badge.className = 'badge';
                                rowMetode.style.display = 'none';
                                rowTenor.style.display = 'none';
                                rowJatuhTempo.style.display = 'none';
                            }
                            updateJatuhTempo();
                        }
                        // Hitung tanggal jatuh tempo
                        function updateJatuhTempo() {
                            let tenor = parseInt(document.getElementById('tenorInput').value) || 0;
                            let tglNota = getTanggalNotaYmd();
                            if (tenor > 0 && tglNota) {
                                let tgl = new Date(tglNota);
                                tgl.setDate(tgl.getDate() + tenor);
                                let jatuhTempo = tgl.getFullYear() + '-' + String(tgl.getMonth() + 1).padStart(2, '0') + '-' + String(tgl.getDate()).padStart(2, '0');
                                document.getElementById('jatuhTempoInput').value = jatuhTempo;
                            } else {
                                document.getElementById('jatuhTempoInput').value = '';
                            }
                        }
                        document.getElementById('paymentAInput').addEventListener('input', updatePaymentStatus);
                        document.getElementById('tenorInput').addEventListener('input', updateJatuhTempo);
                        document.getElementById('tanggal_nota').addEventListener('change', updateJatuhTempo);
                        setTimeout(updatePaymentStatus, 500);
                    </script>
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content sales-modal-content bg-white text-dark bg-dark-mode">
            <div class="modal-header sales-modal-header bg-primary text-white bg-dark-mode-header">
                <h5 class="modal-title sales-modal-title text-white" id="modalBarangLabel"><i data-feather="package" class="me-2"></i> Pilih Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body sales-modal-body bg-white text-dark bg-dark-mode-body">
                <input type="text" id="searchBarang" class="form-control mb-3 sales-modal-input bg-white text-dark bg-dark-mode-input" placeholder="Cari Barang...">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0 sales-modal-table bg-white text-dark bg-dark-mode-table" id="tableBarangModal">
                        <thead class="sales-modal-thead bg-light text-dark bg-dark-mode-thead">
                            <tr>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($barangList as $barang): ?>
                                <tr>
                                    <td><?= esc($barang['name']) ?></td>
                                    <td>Rp <?= number_format($barang['price'], 0, ',', '.') ?></td>
                                    <td class="align-items-center">
                                        <button type="button" class="btn btn-success btn-sm pilih-barang" data-id="<?= $barang['id'] ?>" data-nama="<?= esc($barang['name']) ?>" data-harga="<?= $barang['price'] ?>">Pilih</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer sales-modal-footer bg-white text-dark bg-dark-mode-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
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
            if (this.dataset.salesId) {
                document.getElementById('salesId').value = this.dataset.salesId;
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
    // Helper untuk soft delete barang
    function softDeleteRow(row) {
        row.style.opacity = '0.5';
        row.querySelectorAll('input,button').forEach(el => el.disabled = true);
        // Tambahkan hidden input deleted[] agar controller tahu barang ini dihapus
        if (!row.querySelector('input[name="deleted[]"]')) {
            let deletedInput = document.createElement('input');
            deletedInput.type = 'hidden';
            deletedInput.name = 'deleted[]';
            deletedInput.value = row.getAttribute('data-barang-id');
            row.appendChild(deletedInput);
        }
        updateGrandTotal();
    }

    // Aktifkan event tombol hapus untuk semua baris yang sudah ada (server-side render)
    document.querySelectorAll('#tableBarang .btn-hapus-barang').forEach(function(btn) {
        btn.onclick = function() {
            var row = btn.closest('tr');
            softDeleteRow(row);
        };
    });

    document.getElementById('tableBarangModal').addEventListener('click', function(e) {
        if (e.target.classList.contains('pilih-barang')) {
            var btn = e.target;
            var barangId = btn.getAttribute('data-id');
            var barangName = btn.getAttribute('data-nama');
            var barangPrice = btn.getAttribute('data-harga');
            var modalEl = document.getElementById('modalBarang');
            if (modalEl) {
                var modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                modalInstance.hide();
            }
            var tbody = document.querySelector('#tableBarang tbody');
            var exists = false;
            var deletedRow = null;
            tbody.querySelectorAll('tr[data-barang-id]').forEach(function(tr) {
                if (tr.dataset.barangId == barangId) {
                    // Cek apakah baris status deleted (ada input[name='deleted[]'])
                    if (tr.querySelector('input[name="deleted[]"]')) {
                        deletedRow = tr;
                    } else {
                        exists = true;
                    }
                }
            });
            if (exists) {
                alert('Barang sudah ada di daftar!');
                return;
            }
            // Jika ada baris deleted, hapus dari DOM agar bisa pilih ulang
            if (deletedRow) {
                deletedRow.remove();
            }
            var newRow = document.createElement('tr');
            newRow.setAttribute('data-barang-id', barangId);
            newRow.innerHTML = `
                    <td><img src='/public/assets/img/no-image.png' style='width:40px;height:40px;object-fit:cover;border-radius:6px;'></td>
                    <td class="td-nama-barang">${barangName}</td>
                    <td>Rp ${parseInt(barangPrice).toLocaleString('id-ID')}</td>
                    <td><input type="number" name="qty[]" value="1" min="1" class="form-control form-control-sm jumlah-input" style="width:70px;display:inline-block;"><input type="hidden" name="barang_id[]" value="${barangId}"></td>
                    <td class="subtotal" data-value="${barangPrice}" style="text-align:right;">Rp ${parseInt(barangPrice).toLocaleString('id-ID')}</td>
                    <td><button type="button" class="btn btn-danger btn-sm btn-hapus-barang"><i class="fas fa-trash"></i></button></td>`;
            newRow.querySelector('.btn-hapus-barang').onclick = function() {
                // Soft delete: tandai baris sebagai deleted, jangan hapus dari DOM
                newRow.style.opacity = '0.5';
                newRow.querySelectorAll('input,button').forEach(el => el.disabled = true);
                // Tambahkan hidden input deleted[] agar controller tahu barang ini dihapus
                let deletedInput = document.createElement('input');
                deletedInput.type = 'hidden';
                deletedInput.name = 'deleted[]';
                deletedInput.value = newRow.getAttribute('data-barang-id');
                newRow.appendChild(deletedInput);
                updateGrandTotal();
                // Optionally, bisa tambahkan tombol undo
            };
            // Qty inline edit (identik dengan POS)
            newRow.querySelector('.jumlah-input').addEventListener('input', function() {
                var jumlah = parseInt(this.value);
                if (!jumlah || jumlah < 1) this.value = 1;
                var harga = parseInt(barangPrice);
                var subtotal = (parseInt(this.value) || 1) * harga;
                newRow.querySelector('.subtotal').dataset.value = subtotal;
                newRow.querySelector('.subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
                newRow.querySelector('input[name="qty[]"]').value = this.value;
                updateGrandTotal();
            });
            tbody.appendChild(newRow);
            updateGrandTotal();
        }
    });
    document.getElementById('modalBarang').addEventListener('show.bs.modal', function() {
        document.getElementById('searchBarang').value = '';
    });
    document.getElementById('searchBarang').addEventListener('input', function() {
        let val = this.value.toLowerCase();
        document.querySelectorAll('#tableBarangModal tbody tr').forEach(tr => {
            let nama = tr.children[0].innerText.toLowerCase();
            let harga = tr.children[1].innerText.toLowerCase();
            tr.style.display = (nama.includes(val) || harga.includes(val)) ? '' : 'none';
        });
    });
    let barangList = <?php echo json_encode($barangList); ?>;
    let tableBody = document.querySelector('#tableBarang tbody');
    let grandTotal = 0;

    function updateGrandTotal() {
        let total = 0;
        tableBody.querySelectorAll('tr').forEach(tr => {
            // Hitung hanya barang yang tidak ter-disable (belum dihapus/soft delete)
            if (!tr.querySelector('input[name="deleted[]"]')) {
                total += parseInt(tr.querySelector('.subtotal').dataset.value || 0);
            }
        });
        document.getElementById('grandTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('totalInput').value = total;
        document.getElementById('grandTotalInput').value = total;
        updateSisaPelunasan();
    }
    // Validasi tanggal dengan batas tanggal
    const tanggalNota = document.getElementById('tanggalNota');
    <?php if (isset($batasTanggal)): ?>
        tanggalNota.setAttribute('min', '<?= $batasTanggal['min'] ?>');
        tanggalNota.setAttribute('max', '<?= $batasTanggal['max'] ?>');
    <?php endif; ?>
</script>
<?= $this->endSection(); ?>