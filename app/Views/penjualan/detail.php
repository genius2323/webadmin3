<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card animate__animated animate__fadeInUp mb-4">
        <div class="card-header">
          <h3 class="card-title">Detail Penjualan: <?= esc($penjualan['nomor_nota']); ?></h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <p><strong>Nomor Nota:</strong> <?= esc($penjualan['nomor_nota']); ?></p>
              <p><strong>Tanggal Nota:</strong> <?= esc(date('d/m/Y', strtotime($penjualan['tanggal_nota']))); ?></p>
              <p><strong>Customer:</strong> <?= esc($penjualan['customer']); ?></p>
              <p><strong>Sales:</strong> <?= esc($penjualan['sales']); ?></p>
            </div>
            <div class="col-md-6">
              <p><strong>Status:</strong> <span class="badge badge-secondary"><?= esc(ucfirst($penjualan['status'])); ?></span></p>
              <p><strong>Total Harga:</strong> Rp <?= number_format($penjualan['grand_total'], 0, ',', '.'); ?></p>
            </div>
          </div>

          <h4>Daftar Item</h4>


          <button type="button" class="btn btn-primary btn-block" style="width: 150px; margin-bottom: 10px;" data-bs-toggle="modal" data-bs-target="#modalPilihBarang">
            <i class="fa fa-plus"></i> Tambah
          </button>

          <style>
            /* Konsisten margin top semua modal detail penjualan */
            .modal-dialog {
              margin-top: 70px;
            }

            @media (max-width: 576px) {
              .modal-dialog {
                margin-top: 30px;
              }
            }
          </style>
          <div class="modal fade" id="modalPilihBarang" tabindex="-1" aria-labelledby="modalPilihBarangLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalPilihBarangLabel">Pilih Barang</h5>
                  <!-- tombol close dihapus agar konsisten -->
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <input type="text" id="searchBarang" class="form-control" placeholder="Cari">
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tableBarangModal">
                      <thead>
                        <tr>
                          <th>Nama Barang</th>
                          <th>Kategori</th>
                          <th>Harga</th>
                          <th>Stok</th>
                          <th class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (isset($masterBarang) && !empty($masterBarang)): ?>
                          <?php foreach ($masterBarang as $barang): ?>
                            <tr>
                              <td class="text-left" style="white-space: nowrap !important;"><?= esc($barang['name']) ?></td>
                              <td><?= esc($barang['category_name'] ?? '-') ?></td>
                              <td class="text-right" style="white-space: nowrap !important;">Rp <?= number_format($barang['price'], 0, ',', '.') ?></td>
                              <td class="text-right"><?= esc($barang['stock']) ?></td>
                              <td class="text-center">
                                <button type="button" class="btn btn-success btn-sm pilih-barang-btn" data-id="<?= $barang['id'] ?>" data-nama="<?= esc($barang['name']) ?>" <?= ($barang['stock'] <= 0 ? 'disabled style="pointer-events:none;opacity:0.6;"' : '') ?>>
                                  <i class="fa fa-check"></i>
                                </button>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="5" class="text-center">Tidak ada data barang.</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <!-- Tombol Lanjut dihapus dari modal pilih barang -->
                </div>
              </div>
            </div>
          </div>




          <script>
            // Search filter barang
            document.addEventListener('DOMContentLoaded', function() {
              var searchInput = document.getElementById('searchBarang');
              if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                  var filter = searchInput.value.toLowerCase();
                  var rows = document.querySelectorAll('#tableBarangModal tbody tr');
                  rows.forEach(function(row) {
                    var nama = row.cells[0].textContent.toLowerCase();
                    row.style.display = nama.indexOf(filter) > -1 ? '' : 'none';
                  });
                });
              }
              // Pilih barang
              var pilihBtns = document.querySelectorAll('.pilih-barang-btn');
              pilihBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                  var id = btn.getAttribute('data-id');
                  var nama = btn.getAttribute('data-nama');
                  // Ambil data harga dan stok dari baris
                  var row = btn.closest('tr');
                  var harga = row.cells[2].textContent.replace(/[^\d]/g, '');
                  var stok = parseInt(row.cells[3].textContent);
                  // Bootstrap 5: tutup modal
                  var modalEl = document.getElementById('modalPilihBarang');
                  if (modalEl) {
                    var modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modalInstance.hide();
                  }
                  // Cek apakah barang sudah ada di tabel
                  var itemsTable = document.querySelector('.table-responsive-custom table');
                  var exists = false;
                  var rows = itemsTable.querySelectorAll('tbody tr');
                  rows.forEach(function(tr) {
                    if (tr.dataset.barangId == id) exists = true;
                  });
                  if (exists) {
                    alert('Barang sudah ada di daftar!');
                    return;
                  }
                  // Tambahkan baris baru ke tabel item
                  var tbody = itemsTable.querySelector('tbody');
                  // Hapus baris info kosong jika ada
                  var infoRow = tbody.querySelector('.row-info-empty');
                  if (infoRow) infoRow.remove();
                  // Hitung ulang nomor urut
                  var trs = tbody.querySelectorAll('tr[data-barang-id]');
                  var no = trs.length + 1;
                  var newRow = document.createElement('tr');
                  newRow.setAttribute('data-barang-id', id);
                  newRow.innerHTML = `
                            <td>${no}</td>
                            <td>${nama}</td>
                            <td><input type="number" min="1" max="${stok}" value="1" class="form-control form-control-sm jumlah-input" style="width:70px;"></td>
                            <td class="text-right">Rp <span class="harga-satuan">${parseInt(harga).toLocaleString('id-ID')}</span></td>
                            <td><input type="number" min="0" max="100" value="" class="form-control form-control-sm diskon-persen-input" style="width:50px;" placeholder=""> </td>
                            <td class="align-items-right"><input type="number" min="0" value="" class="text-right form-control form-control-sm diskon-rp-input" style="width:100px;" placeholder="Rp"></td>
                            <td class="text-right">Rp <span class="subtotal">${parseInt(harga).toLocaleString('id-ID')}</span></td>
                            <td><button type="button" class="btn btn-danger btn-sm hapus-item-btn"><i class="fa fa-trash"></i> Hapus</button></td>
                          `;
                  tbody.appendChild(newRow);
                  updateGrandTotal();
                  // Event input jumlah
                  newRow.querySelector('.jumlah-input').addEventListener('input', function() {
                    var jumlah = parseInt(this.value) || 1;
                    var harga = parseInt(newRow.querySelector('.harga-satuan').textContent.replace(/[^\d]/g, ''));
                    var subtotal = jumlah * harga;
                    hitungSubtotal();
                    updateGrandTotal();
                  });

                  function hitungSubtotal() {
                    var jumlah = parseInt(newRow.querySelector('.jumlah-input').value) || 1;
                    var harga = parseInt(newRow.querySelector('.harga-satuan').textContent.replace(/[^\d]/g, ''));
                    var diskonPersen = parseFloat(newRow.querySelector('.diskon-persen-input').value) || 0;
                    var diskonRp = parseInt(newRow.querySelector('.diskon-rp-input').value) || 0;
                    var subtotalAwal = jumlah * harga;
                    var diskonNominal = Math.round(subtotalAwal * (diskonPersen / 100));
                    var subtotalAkhir = subtotalAwal - diskonNominal - diskonRp;
                    if (subtotalAkhir < 0) subtotalAkhir = 0;
                    newRow.querySelector('.subtotal').textContent = subtotalAkhir.toLocaleString('id-ID');
                  }
                  newRow.querySelector('.diskon-persen-input').addEventListener('input', function() {
                    hitungSubtotal();
                    updateGrandTotal();
                  });
                  newRow.querySelector('.diskon-rp-input').addEventListener('input', function() {
                    hitungSubtotal();
                    updateGrandTotal();
                  });
                  hitungSubtotal();
                  // Event hapus
                  newRow.querySelector('.hapus-item-btn').addEventListener('click', function() {
                    newRow.remove();
                    updateGrandTotal();
                    // Update nomor urut
                    var trs = itemsTable.querySelectorAll('tbody tr[data-barang-id]');
                    trs.forEach(function(tr, idx) {
                      tr.cells[0].textContent = idx + 1;
                    });
                    // Jika tabel kosong, tampilkan info
                    if (trs.length === 0) {
                      var infoRow = document.createElement('tr');
                      infoRow.className = 'row-info-empty';
                      infoRow.innerHTML = `<td colspan='8' class='text-center bg-info bg-opacity-0'>Belum ada item yang ditambahkan.</td>`;
                      tbody.appendChild(infoRow);
                    }
                  });
                });
              });
              // Hitung total harga
              function updateGrandTotal() {
                var itemsTable = document.querySelector('.table-responsive-custom table');
                var trs = itemsTable.querySelectorAll('tbody tr[data-barang-id]');
                var total = 0;
                var totalDiskon = 0;
                trs.forEach(function(tr) {
                  var jumlah = parseInt(tr.querySelector('.jumlah-input')?.value) || 1;
                  var harga = parseInt(tr.querySelector('.harga-satuan')?.textContent.replace(/[^\d]/g, '')) || 0;
                  var diskonPersen = parseFloat(tr.querySelector('.diskon-persen-input')?.value) || 0;
                  var diskonRp = parseInt(tr.querySelector('.diskon-rp-input')?.value) || 0;
                  var subtotalAwal = jumlah * harga;
                  var diskonNominal = Math.round(subtotalAwal * (diskonPersen / 100));
                  var subtotalAkhir = subtotalAwal - diskonNominal - diskonRp;
                  if (subtotalAkhir < 0) subtotalAkhir = 0;
                  total += subtotalAkhir;
                  totalDiskon += diskonNominal + diskonRp;
                });
                var totalHargaEl = document.getElementById('totalHargaRp');
                if (totalHargaEl) totalHargaEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
                var totalDiskonEl = document.getElementById('totalDiskonRp');
                if (totalDiskonEl) totalDiskonEl.textContent = 'Rp ' + totalDiskon.toLocaleString('id-ID');

                // Update juga total harga di modal tunai jika modal terbuka
                var modalTunai = document.getElementById('modalTunai');
                var modalTotalHarga = document.getElementById('modalTotalHarga');
                var modalTotalHargaAngka = document.getElementById('modalTotalHargaAngka');

                if (modalTotalHarga) modalTotalHarga.value = 'Rp ' + total.toLocaleString('id-ID');
                if (modalTotalHargaAngka) modalTotalHargaAngka.value = total;

              }
            });
          </script>

          <div class="table-responsive-custom">
            <table class="table table-bordered table-hover table-striped table-sm" style="font-size:0.95em;">
              <thead>
                <tr>
                  <th class="text-center">No.</th>
                  <th class="text-center">Nama Barang</th>
                  <th class="text-center">Jumlah</th>
                  <th class="text-center">Harga Satuan</th>
                  <th class="text-center">Discount (%)</th>
                  <th class="text-center">Discount (Rp)</th>
                  <th class="text-center">Subtotal</th>
                  <th class="text-center">Hapus</th>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($items) && !empty($items)) : ?>
                  <?php $no = 1; ?>
                  <?php foreach ($items as $item) : ?>
                    <tr>
                      <td style="white-space: nowrap !important;"><?= $no++; ?></td>
                      <td style="white-space: nowrap !important;"><?= esc($item['nama_barang']); ?></td>
                      <td style="white-space: nowrap !important;"><?= esc($item['jumlah']); ?></td>
                      <td class="text-right" style="white-space: nowrap !important;">Rp <?= number_format($item['harga_satuan'], 0, ',', '.'); ?></td>
                      <td class="text-right" style="white-space: nowrap !important;">Rp <?= number_format($item['jumlah'] * $item['harga_satuan'], 0, ',', '.'); ?></td>
                      <td class="text-center">
                        <a href="/penjualan/deleteItem/<?= esc($item['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">Hapus</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else : ?>
                  <tr class="row-info-empty">
                    <td colspan="8" class="text-center bg-opacity-0">Belum ada item yang ditambahkan.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          <link rel="stylesheet" href="<?= base_url('assets/css/table-responsive-custom.css') ?>">

          <!-- Box Total Diskon dan Total Harga + Metode Pembayaran -->
          <div class="row mt-3">
            <div class="col-md-8 offset-md-4">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-2">
                    <span><strong>Total Diskon (Rp):</strong></span>
                    <span id="totalDiskonRp">Rp 0</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span><strong>Total Harga:</strong></span>
                    <span id="totalHargaRp" data-grand-total>Rp 0</span>
                  </div>

                  <!-- Pembayaran baru: Tab & Form Dinamis -->
                  <div id="area-pembayaran-baru" class="mt-4">
                    <div class="card">
                      <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="tabPembayaran" role="tablist">
                          <li class="nav-item">
                            <button class="nav-link active" id="tab-tunai" data-bs-toggle="tab" data-bs-target="#pane-tunai" type="button" role="tab">Tunai</button>
                          </li>
                          <li class="nav-item">
                            <button class="nav-link" id="tab-qris" data-bs-toggle="tab" data-bs-target="#pane-qris" type="button" role="tab">QRIS</button>
                          </li>
                          <li class="nav-item">
                            <button class="nav-link" id="tab-transfer" data-bs-toggle="tab" data-bs-target="#pane-transfer" type="button" role="tab">Transfer</button>
                          </li>
                          <li class="nav-item">
                            <button class="nav-link" id="tab-kredit" data-bs-toggle="tab" data-bs-target="#pane-kredit" type="button" role="tab">Kredit</button>
                          </li>
                        </ul>
                      </div>
                      <div class="card-body">
                        <div class="tab-content" id="tabPembayaranContent">
                          <!-- Tunai -->
                          <div class="tab-pane fade show active" id="pane-tunai" role="tabpanel">
                            <form id="formTunaiBaru">
                              <div class="mb-3">
                                <label class="form-label"><strong>Total Harga</strong></label>
                                <input type="text" class="form-control" id="tunaiTotalHarga" value="Rp 0" readonly>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Uang Tunai Diberikan</label>
                                <input type="number" min="0" class="form-control" id="tunaiUangDiberikan" placeholder="Masukkan nominal tunai">
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Kembalian</label>
                                <input type="text" class="form-control" id="tunaiKembalian" readonly>
                              </div>
                              <button type="button" class="btn btn-success w-100" id="btnProsesTunai">Proses Pembayaran Tunai</button>
                            </form>
                          </div>
                          <!-- QRIS -->
                          <div class="tab-pane fade" id="pane-qris" role="tabpanel">
                            <form id="formQrisBaru">
                              <div class="mb-3">
                                <label class="form-label"><strong>Total Harga</strong></label>
                                <input type="text" class="form-control" id="qrisTotalHarga" value="Rp 0" readonly>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">No. Referensi QRIS</label>
                                <input type="text" class="form-control" id="qrisRef" placeholder="Masukkan kode referensi QRIS">
                              </div>
                              <button type="button" class="btn btn-success w-100" id="btnProsesQris">Proses Pembayaran QRIS</button>
                            </form>
                          </div>
                          <!-- Transfer -->
                          <div class="tab-pane fade" id="pane-transfer" role="tabpanel">
                            <form id="formTransferBaru">
                              <div class="mb-3">
                                <label class="form-label"><strong>Total Harga</strong></label>
                                <input type="text" class="form-control" id="transferTotalHarga" value="Rp 0" readonly>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Bank</label>
                                <input type="text" class="form-control" id="transferBank" placeholder="Nama bank">
                              </div>
                              <div class="mb-3">
                                <label class="form-label">No. Referensi Transfer</label>
                                <input type="text" class="form-control" id="transferRef" placeholder="Masukkan kode referensi transfer">
                              </div>
                              <button type="button" class="btn btn-success w-100" id="btnProsesTransfer">Proses Pembayaran Transfer</button>
                            </form>
                          </div>
                          <!-- Kredit -->
                          <div class="tab-pane fade" id="pane-kredit" role="tabpanel">
                            <form id="formKreditBaru">
                              <div class="mb-3">
                                <label class="form-label"><strong>Total Harga</strong></label>
                                <input type="text" class="form-control" id="kreditTotalHarga" value="Rp 0" readonly>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Nama Kreditur</label>
                                <input type="text" class="form-control" id="kreditNama" placeholder="Nama kreditur">
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Jatuh Tempo</label>
                                <input type="date" class="form-control" id="kreditJatuhTempo">
                              </div>
                              <button type="button" class="btn btn-success w-100" id="btnProsesKredit">Proses Pembayaran Kredit</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <script>
                    // Sinkronisasi total harga ke semua tab pembayaran
                    function syncTotalHargaPembayaran() {
                      var totalHargaEl = document.getElementById('totalHargaRp');
                      var totalHargaStr = totalHargaEl ? totalHargaEl.textContent.trim() : 'Rp 0';
                      document.getElementById('tunaiTotalHarga').value = totalHargaStr;
                      document.getElementById('qrisTotalHarga').value = totalHargaStr;
                      document.getElementById('transferTotalHarga').value = totalHargaStr;
                      document.getElementById('kreditTotalHarga').value = totalHargaStr;
                    }
                    // Jalankan setiap updateGrandTotal
                    var _oldUpdateGrandTotal = window.updateGrandTotal;
                    window.updateGrandTotal = function() {
                      if (_oldUpdateGrandTotal) _oldUpdateGrandTotal();
                      syncTotalHargaPembayaran();
                    }
                    // Jalankan saat halaman load
                    document.addEventListener('DOMContentLoaded', function() {
                      syncTotalHargaPembayaran();
                      // Tunai: hitung kembalian
                      var tunaiUang = document.getElementById('tunaiUangDiberikan');
                      var tunaiTotal = document.getElementById('tunaiTotalHarga');
                      var tunaiKembalian = document.getElementById('tunaiKembalian');
                      if (tunaiUang && tunaiTotal && tunaiKembalian) {
                        tunaiUang.addEventListener('input', function() {
                          var total = Number((tunaiTotal.value + '').replace(/[^\d]/g, '')) || 0;
                          var uang = Number((tunaiUang.value + '').replace(/[^\d]/g, '')) || 0;
                          var kembali = uang - total;
                          if (uang < total) {
                            tunaiKembalian.value = 'Uang kurang';
                            tunaiKembalian.classList.add('is-invalid');
                          } else {
                            tunaiKembalian.value = 'Rp ' + kembali.toLocaleString('id-ID');
                            tunaiKembalian.classList.remove('is-invalid');
                          }
                        });
                      }
                    });
                  </script>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-3">
            <a href="<?= site_url('penjualan') ?>" class="btn btn-secondary">Kembali</a>
            <a href="/penjualan/finalize/<?= $penjualan['id']; ?>" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin menyelesaikan penjualan ini?')">Selesaikan Penjualan</a>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Area pembayaran baru akan diisi di sini

    //
  });
  // Modal Bootstrap sudah handle animasi