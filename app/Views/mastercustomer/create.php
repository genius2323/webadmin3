<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<main>
  <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
      <div class="page-header-content">
        <div class="row align-items-center justify-content-between pt-3">
          <div class="col-auto mb-3">
            <h1 class="page-header-title">
              <div class="page-header-icon"><i data-feather="users"></i></div>
              Tambah Customer
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
            <form action="<?= site_url('mastercustomer/save') ?>" method="post" autocomplete="off">
              <?= csrf_field() ?>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="kode_customer" class="form-label">Kode Customer <span class="text-danger">*</span></label>
                    <input type="text" name="kode_customer" id="kode_customer" class="form-control" maxlength="8" required placeholder="Kode Customer">
                  </div>
                  <div class="mb-3">
                    <label for="nama_customer" class="form-label">Nama Customer <span class="text-danger">*</span></label>
                    <input type="text" name="nama_customer" id="nama_customer" class="form-control" required placeholder="Nama Customer">
                  </div>
                  <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat Customer">
                  </div>
                  <div class="mb-3">
                    <label for="kota" class="form-label">Kota</label>
                    <input type="text" name="kota" id="kota" class="form-control" placeholder="Kota">
                  </div>
                  <div class="mb-3">
                    <label for="provinsi" class="form-label">Provinsi</label>
                    <input type="text" name="provinsi" id="provinsi" class="form-control" placeholder="Provinsi">
                  </div>
                  <div class="mb-3">
                    <label for="contact_person" class="form-label">Contact Person</label>
                    <input type="text" name="contact_person" id="contact_person" class="form-control" placeholder="Contact Person">
                  </div>
                  <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP <span class="text-danger">*</span></label>
                    <input type="tel" name="no_hp" id="no_hp" class="form-control" pattern="[0-9]+" inputmode="numeric" maxlength="15" autocomplete="off" placeholder="081234567890" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="sales" class="form-label">Sales</label>
                    <div style="display:flex;gap:8px;align-items:flex-start;">
                      <input type="text" name="sales" id="salesInput" class="form-control" readonly placeholder="Pilih Sales..." style="flex:1;min-width:0;">
                      <button type="button" class="btn btn-primary" style="height:calc(2.25rem + 2px);padding:0 18px;min-width:unset;display:flex;align-items:center;" data-bs-toggle="modal" data-bs-target="#modalSalesSBAdmin">Pilih Sales</button>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="batas_piutang" class="form-label">Batas Piutang <span class="text-danger">*</span></label>
                    <input type="text" name="batas_piutang" id="batas_piutang" class="form-control" inputmode="numeric" autocomplete="off" placeholder="Rp 0" required>
                  </div>
                  <div class="card mb-3">
                    <div class="card-header bg-primary text-white">Data NPWP</div>
                    <div class="card-body">
                      <div class="mb-2">
                        <label class="form-label">Nomor</label>
                        <div class="npwp-nomor-group" style="display:flex;gap:2px;align-items:center;justify-content:left;flex-wrap:wrap;">
                          <?php for ($i = 0; $i < 15; $i++):
                            if ($i > 0) {
                              if ($i == 2 || $i == 5 || $i == 8) echo '<span style=\'font-weight:bold;color:#64748b\'>.</span>';
                              if ($i == 9) echo '<span style=\'font-weight:bold;color:#64748b\'>-</span>';
                              if ($i == 12) echo '<span style=\'font-weight:bold;color:#64748b\'>.</span>';
                            }
                          ?>
                            <input type="tel" name="npwp_nomor[]" maxlength="1" pattern="[0-9]" inputmode="numeric" class="form-control text-center" autocomplete="off" style="width:32px;height:38px;font-size:1.1rem;padding:1px 2px;text-align:center;">
                          <?php endfor; ?>
                        </div>
                      </div>
                      <div class="mb-3">
                        <label for="npwp_atas_nama" class="form-label">Atas Nama</label>
                        <input type="text" name="npwp_atas_nama" id="npwp_atas_nama" class="form-control" placeholder="Atas Nama NPWP">
                      </div>
                      <div class="mb-3">
                        <label for="npwp_alamat" class="form-label">Alamat</label>
                        <input type="text" name="npwp_alamat" id="npwp_alamat" class="form-control" placeholder="Alamat NPWP">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary">
                  <i data-feather="save" class="me-1"></i> Simpan Customer
                </button>
                <a href="<?= site_url('mastercustomer') ?>" class="btn btn-danger ms-2">Batal</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
  $(document).ready(function() {
    if (window.feather) feather.replace();
    $('.form-select').select2({
      theme: 'default',
      width: '100%',
      placeholder: function() {
        return $(this).attr('placeholder') || 'Pilih';
      },
      allowClear: true
    });
    // Format input Batas Piutang ke format Rupiah
    var piutangInput = document.getElementById('batas_piutang');
    if (piutangInput) {
      piutangInput.addEventListener('input', function(e) {
        let value = this.value.replace(/[^\d]/g, '');
        if (value.length > 15) value = value.slice(0, 15);
        let formatted = value ? 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, ".") : '';
        this.value = formatted;
      });
      piutangInput.addEventListener('blur', function() {
        if (!this.value) this.value = 'Rp 0';
      });
      piutangInput.addEventListener('focus', function() {
        if (this.value === 'Rp 0') this.value = '';
      });
    }

    // NPWP: auto next/prev input
    var npwpInputs = document.querySelectorAll('.npwp-nomor-group input');
    npwpInputs.forEach(function(input, idx) {
      input.addEventListener('input', function(e) {
        if (this.value.length === 1 && idx < npwpInputs.length - 1) {
          npwpInputs[idx + 1].focus();
        }
      });
      input.addEventListener('keydown', function(e) {
        if ((e.key === 'Backspace' || e.key === 'Delete') && !this.value && idx > 0) {
          npwpInputs[idx - 1].focus();
        }
      });
      input.addEventListener('paste', function(e) {
        var paste = (e.clipboardData || window.clipboardData).getData('text');
        paste = paste.replace(/[^0-9]/g, '');
        if (paste.length > 0) {
          for (let i = 0; i < paste.length && (idx + i) < npwpInputs.length; i++) {
            npwpInputs[idx + i].value = paste[i];
          }
          const nextIdx = Math.min(idx + paste.length, npwpInputs.length - 1);
          setTimeout(() => {
            npwpInputs[nextIdx].focus();
            npwpInputs[nextIdx].select();
          }, 0);
        }
      });
    });

    // Modal Pilih Sales: load data sales saat modal dibuka
    var modalSales = document.getElementById('modalSalesSBAdmin');
    if (modalSales) {
      modalSales.addEventListener('show.bs.modal', function() {
        loadSalesModal();
        document.getElementById('searchSales').value = '';
      });
    }

    // Search sales di modal
    var searchSales = document.getElementById('searchSales');
    if (searchSales) {
      searchSales.addEventListener('input', function() {
        loadSalesModal(this.value);
      });
    }
  });

  // Fungsi loadSalesModal: ambil data sales via AJAX dan tampilkan di tabel
  function loadSalesModal(keyword = '') {
    fetch('/webadmin3/public/salesapi.php?search=' + encodeURIComponent(keyword))
      .then(res => res.json())
      .then(data => {
        const tbody = document.querySelector('#tableSalesModal tbody');
        tbody.innerHTML = '';
        if (data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="3" class="text-center">Tidak ada data</td></tr>';
        } else {
          data.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                            <td>${row.kode}</td>
                            <td>${row.nama}</td>
                            <td class="align-items-center"><button type="button" class="btn btn-success btn-sm pilih-sales-btn" data-kode="${row.kode}" data-nama="${row.nama}">Pilih</button></td>
                        `;
            tbody.appendChild(tr);
          });
        }
      });
  }

  // Pilih sales dari modal
  document.body.addEventListener('click', function(e) {
    if (e.target.classList.contains('pilih-sales-btn')) {
      const kode = e.target.getAttribute('data-kode');
      const nama = e.target.getAttribute('data-nama');
      document.getElementById('salesInput').value = kode + ' - ' + nama;
      var modal = bootstrap.Modal.getInstance(document.getElementById('modalSalesSBAdmin'));
      if (modal) {
        modal.hide();
      }
    }
  });
</script>
<!-- Modal Pilih Sales SBAdmin -->
<div class="modal fade" id="modalSalesSBAdmin" tabindex="-1" aria-labelledby="modalSalesSBAdminLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content sales-modal-content bg-white text-dark bg-dark-mode">
      <div class="modal-header sales-modal-header bg-primary text-white bg-dark-mode-header">
        <h5 class="modal-title sales-modal-title text-white" id="modalSalesSBAdminLabel"><i data-feather="users" class="me-2"></i> Pilih Sales</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body sales-modal-body bg-white text-dark bg-dark-mode-body">
        <input type="text" id="searchSales" class="form-control mb-3 sales-modal-input bg-white text-dark bg-dark-mode-input" placeholder="Cari Sales...">
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle mb-0 sales-modal-table bg-white text-dark bg-dark-mode-table" id="tableSalesModal">
            <thead class="sales-modal-thead bg-light text-dark bg-dark-mode-thead">
              <tr>
                <th class="text-center">Kode</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <!-- Data sales akan di-load via JS -->
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

<style>
  /* Tombol aksi di tengah pada tabel modal sales SBAdmin */
  .sales-modal-table td:last-child {
    text-align: center;
    vertical-align: middle !important;
  }

  /* Border abu-abu untuk input cari sales di modal sales SBAdmin */
  .sales-modal-input {
    border: 1.5px solid #cbd5e1 !important;
    box-shadow: none !important;
  }

  /* Utility class for dark mode modal sales SBAdmin */
  body.dark-mode .bg-dark-mode,
  body.dark-mode .bg-dark-mode-body,
  body.dark-mode .bg-dark-mode-header,
  body.dark-mode .bg-dark-mode-footer,
  body.dark-mode .bg-dark-mode-table,
  body.dark-mode .bg-dark-mode-thead,
  body.dark-mode .bg-dark-mode-input {
    background: #181f2a !important;
    color: #f3f4f6 !important;
    border-color: #26334d !important;
    box-shadow: none !important;
  }

  body.dark-mode .bg-dark-mode-header {
    background: #0d47a1 !important;
    color: #fff !important;
    border-bottom: 1.5px solid #26334d !important;
  }

  body.dark-mode .bg-dark-mode-thead th {
    background: #232b3a !important;
    color: #fff !important;
    border-color: #26334d !important;
  }

  body.dark-mode .bg-dark-mode-table th,
  body.dark-mode .bg-dark-mode-table td {
    background: #181f2a !important;
    color: #f3f4f6 !important;
    border-color: #26334d !important;
  }

  body.dark-mode .btn-primary,
  body.dark-mode .modal-footer .btn-primary {
    background: #1565c0 !important;
    border-color: #1565c0 !important;
    color: #fff !important;
    box-shadow: none !important;
  }

  body.dark-mode .btn-success {
    background: #43a047 !important;
    border-color: #43a047 !important;
    color: #fff !important;
    box-shadow: none !important;
  }

  body.dark-mode .btn-close {
    filter: invert(1) brightness(1.5) !important;
  }

  body.dark-mode .sales-modal-content {
    border-radius: 16px !important;
    border: 1.5px solid #26334d !important;
  }

  .modal-dialog {
    margin-top: 70px;
  }

  /* Border radius untuk tabel di modal sales SBAdmin */
  .sales-modal-table {
    border-radius: 8px !important;
    overflow: hidden;
    border-collapse: separate !important;
    border-spacing: 0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    border: 1px solid #dee2e6 !important;
  }

  .sales-modal-table th:first-child {
    border-top-left-radius: 8px !important;
  }

  .sales-modal-table th:last-child {
    border-top-right-radius: 8px !important;
  }

  .sales-modal-table tr:last-child td:first-child {
    border-bottom-left-radius: 8px !important;
  }

  .sales-modal-table tr:last-child td:last-child {
    border-bottom-right-radius: 8px !important;
  }

  .sales-modal-table th,
  .sales-modal-table td {
    border: 0.5px solid #dee2e6 !important;
  }

  .sales-modal-table th:first-child,
  .sales-modal-table td:first-child {
    border-left: 0.5px solid #dee2e6 !important;
  }

  .sales-modal-table th:last-child,
  .sales-modal-table td:last-child {
    border-right: 0.5px solid #dee2e6 !important;
  }

  .sales-modal-table tr:first-child th {
    border-top: 0.5px solid #dee2e6 !important;
  }

  .sales-modal-table tr:last-child td {
    border-bottom: 0.5px solid #dee2e6 !important;
  }

  @media (max-width: 576px) {
    .modal-dialog {
      margin-top: 30px;
    }
  }
</style>
<?= $this->endSection(); ?>