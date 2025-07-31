<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<style>
  .customer-modern-header {
    display: flex;
    align-items: center;
    gap: 18px;
    margin-bottom: 18px;
    max-width: 700px;
  }

  .customer-modern-icon {
    background: #fff;
    width: 54px;
    height: 54px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    box-shadow: 0 2px 8px 0 rgba(30, 41, 59, 0.10);
  }

  .customer-modern-title {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: 0.2px;
    color: #1e293b;
  }

  .customer-modern-subtitle {
    font-size: 1.05rem;
    color: #64748b;
    margin-top: 2px;
  }

  .customer-modern-form {
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 4px 32px 0 rgba(30, 41, 59, 0.10);
    padding: clamp(18px, 5vw, 36px) clamp(12px, 5vw, 32px) clamp(14px, 4vw, 28px) clamp(12px, 5vw, 32px);
    max-width: 700px;
    margin: 0 auto;
  }

  .customer-modern-form label {
    font-weight: 600;
    margin-bottom: 6px;
    color: #1e293b;
    display: block;
    text-align: left;
    font-size: clamp(0.98rem, 2.5vw, 1.08rem);
  }

  .customer-modern-form .form-control {
    border-radius: 12px;
    font-size: clamp(0.98rem, 2.5vw, 1.08rem);
    padding: clamp(7px, 2vw, 10px) clamp(10px, 3vw, 14px);
    border: 1.5px solid #e2e8f0;
    background: #f8fafc;
    box-shadow: none;
    margin-bottom: clamp(14px, 3vw, 22px);
    transition: border-color 0.2s;
    width: 100%;
    min-width: 0;
    box-sizing: border-box;
  }

  .form-control {
    border-radius: 12px;
    font-size: clamp(0.98rem, 2.5vw, 1.08rem);
    padding: clamp(7px, 2vw, 10px) clamp(10px, 3vw, 14px);
    border: 1.5px solid #e2e8f0;
    background: #f8fafc;
    box-shadow: none;
    margin-bottom: clamp(14px, 3vw, 22px);
    transition: border-color 0.2s;
    width: 100%;
    min-width: 0;
    box-sizing: border-box;
  }

  .customer-modern-form .form-control:focus {
    border-color: #007bff;
    background: #fff;
  }

  .btn-modern {
    border-radius: 10px;
    font-weight: 600;
    font-size: clamp(0.98rem, 2.5vw, 1.08rem);
    padding: clamp(7px, 2vw, 10px) clamp(18px, 5vw, 28px);
    border: none;
    background: #007bff;
    color: #fff;
    transition: background 0.2s;
  }

  @media (max-width: 768px) {
    .customer-modern-form {
      max-width: 98vw;
      padding: clamp(10px, 4vw, 18px) clamp(6px, 4vw, 12px);
    }

    .customer-modern-header {
      max-width: 98vw;
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
    }

    .row {
      flex-direction: column !important;
    }

    .col-lg-4,
    .col-lg-8 {
      max-width: 100%;
      flex: 0 0 100%;
    }
  }

  .btn-modern:hover {
    background: #0056b3;
  }
</style>
<!-- Seluruh konten form dan script sama persis dengan create.php, sudah termasuk modal, style, dan JS -->
<div class="customer-modern-header">
  <div class="customer-modern-icon">
    <img src="<?= base_url('assets/icon/svgs/solid/plus.svg') ?>" alt="plus" width="32" height="32">
  </div>
  <div>
    <div class="customer-modern-title">Edit Customer</div>
    <div class="customer-modern-subtitle">Edit data customer dengan lengkap dan benar.</div>
  </div>
</div>
<form action="<?= site_url('mastercustomer/update/' . $customer['id']) ?>" method="post" autocomplete="off">
  <div style="display:flex;gap:12px;flex-wrap:wrap;">
    <div style="flex:1;min-width:160px;">
      <label for="kode_customer">Kode Customer</label></br>
      <input type="text" name="kode_customer" id="kode_customer" class="form-control" maxlength="8" required style="width:calc(8ch + 18px);min-width:120px;" value="<?= esc($customer['kode_customer']) ?>">
    </div>
    <div style="flex:1;min-width:160px;">
      <label for="nama_customer">Nama Customer</label>
      <input type="text" name="nama_customer" id="nama_customer" class="form-control" required value="<?= esc($customer['nama_customer']) ?>">
    </div>
  </div>
  <label for="alamat">Alamat</label>
  <input type="text" name="alamat" id="alamat" class="form-control" value="<?= esc($customer['alamat']) ?>">
  <div style="display:flex;gap:12px;flex-wrap:wrap;">
    <div style="flex:1;min-width:160px;">
      <label for="kota">Kota</label>
      <input type="text" name="kota" id="kota" class="form-control" value="<?= esc($customer['kota']) ?>">
    </div>
    <div style="flex:1;min-width:160px;">
      <label for="provinsi">Provinsi</label>
      <input type="text" name="provinsi" id="provinsi" class="form-control" value="<?= esc($customer['provinsi']) ?>">
    </div>
  </div>
  <div style="display:flex;gap:12px;flex-wrap:wrap;">
    <div style="flex:1;min-width:160px;">
      <label for="contact_person">Contact Person</label>
      <input type="text" name="contact_person" id="contact_person" class="form-control" value="<?= esc($customer['contact_person']) ?>">
    </div>
    <div style="flex:1;min-width:160px;">
      <label for="no_hp">No HP</label>
      <input type="tel" name="no_hp" id="no_hp" class="form-control" pattern="[0-9]+" inputmode="numeric" maxlength="15" autocomplete="off" placeholder="081234567890" required value="<?= esc($customer['no_hp']) ?>">
    </div>
  </div>
  <label for="sales">Sales</label>
  <div style="display:flex;gap:8px;align-items:flex-start;">
    <input type="text" name="sales" id="salesInput" class="form-control" readonly placeholder="Pilih Sales..." style="flex:1;min-width:0;" value="<?= esc($customer['sales']) ?>">
    <button type="button" class="btn btn-modern" style="padding:4px 18px;height:38px;min-width:unset;" id="openSalesModal">Pilih Sales</button>
  </div>
  <label for="batas_piutang">Batas Piutang</label>
  <input type="text" name="batas_piutang" id="batas_piutang" class="form-control" inputmode="numeric" autocomplete="off" placeholder="Rp 0" required value="<?= esc(number_format($customer['batas_piutang'], 0, ',', '.')) ?>">
  <script>
    // Format input Batas Piutang ke format Rupiah
    document.addEventListener('DOMContentLoaded', function() {
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
    });
  </script>
  <div class="npwp-modern-box" style="background:#f8fafc;border-radius:16px;padding:22px 18px 12px 18px;margin:28px 0 10px 0;box-shadow:0 2px 8px 0 rgba(30,41,59,0.06);">
    <div style="font-weight:600;font-size:1.08rem;color:#1e293b;margin-bottom:10px;">Data NPWP</div>
    <div style="margin-bottom:12px;">
      <label style="margin-bottom:6px;">Nomor</label>
      <div class="npwp-nomor-group" style="display:flex;gap:2px;align-items:center;justify-content:left;flex-wrap:wrap;">
        <?php
        $npwpNomor = str_pad(preg_replace('/[^0-9]/', '', $customer['npwp_nomor'] ?? ''), 15, ' ', STR_PAD_RIGHT);
        for ($i = 0; $i < 15; $i++):
          if ($i > 0) {
            if ($i == 2 || $i == 5 || $i == 8) echo '<span style=\'font-weight:bold;color:#64748b\'>.</span>';
            if ($i == 9) echo '<span style=\'font-weight:bold;color:#64748b\'>-</span>';
            if ($i == 12) echo '<span style=\'font-weight:bold;color:#64748b\'>.</span>';
          }
        ?>
          <input type="tel" name="npwp_nomor[]" maxlength="1" pattern="[0-9]" inputmode="numeric" class="form-control text-center" autocomplete="off" style="width:32px;height:38px;font-size:1.1rem;padding:1px 2px;text-align:center;" value="<?= esc($npwpNomor[$i] ?? '') ?>">
        <?php endfor; ?>
      </div>
    </div>
    <div style="display:flex;gap:12px;flex-wrap:wrap;">
      <div style="flex:1;min-width:160px;">
        <label for="npwp_atas_nama">Atas Nama</label>
        <input type="text" name="npwp_atas_nama" id="npwp_atas_nama" class="form-control" value="<?= esc($customer['npwp_atas_nama']) ?>">
      </div>
      <div style="flex:1;min-width:160px;">
        <label for="npwp_alamat">Alamat</label>
        <input type="text" name="npwp_alamat" id="npwp_alamat" class="form-control" value="<?= esc($customer['npwp_alamat']) ?>">
      </div>
    </div>
  </div>
  <div class="text-center w-100 mt-3">
    <button type="submit" class="btn-modern px-5 py-2" style="text-align:center;">Simpan</button>
    <a href="<?= site_url('mastercustomer') ?>" class="btn-modern btn-secondary px-5 py-2" style="background:#e2e8f0;color:#1e293b;text-align:center;">Batal</a>
  </div>
</form>
<!-- Modal dan script custom sales, style, dan JS dari create.php juga sudah disalin ke sini agar identik -->
<div id="customSalesModal" class="custom-modal">
  <div class="custom-modal-content">
    <div class="custom-modal-header">
      <span class="custom-modal-title">Pilih Sales</span>
      <span class="custom-modal-close" id="closeSalesModal">&times;</span>
    </div>
    <div class="custom-modal-body">
      <input type="text" id="searchSales" class="form-control mb-2" placeholder="Cari Sales...">
      <div class="table-responsive">
        <table class="modern-sales-table" id="tableSalesModal">
          <thead>
            <tr>
              <th style="text-align: center;">Kode</th>
              <th style="text-align: center;">Nama</th>
              <th style="text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <!-- Data sales akan di-load via JS -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<style>
  .modern-sales-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #f8fafc;
    border-radius: 12px;
    overflow: hidden;
    font-size: 1.04rem;
    box-shadow: 0 2px 8px 0 rgba(30, 41, 59, 0.07);
  }

  .modern-sales-table thead tr {
    background: #e2e8f0;
  }

  .modern-sales-table th,
  .modern-sales-table td {
    padding: 10px 14px;
    text-align: left;
  }

  .modern-sales-table th {
    color: #1e293b;
    font-weight: 700;
    font-size: 1.05rem;
    border-bottom: 2px solid #cbd5e1;
  }

  .modern-sales-table tbody tr {
    transition: background 0.15s;
  }

  .modern-sales-table tbody tr:hover {
    background: #e0e7ef;
  }

  .modern-sales-table td {
    color: #334155;
    border-bottom: 1px solid #e2e8f0;
  }

  .modern-sales-table td:last-child {
    text-align: center;
    vertical-align: middle;
  }

  .modern-sales-table .btn-success {
    margin: 0 auto;
  }

  .modern-sales-table tr:last-child td {
    border-bottom: none;
  }

  .modern-sales-table .btn-success {
    background: #22c55e;
    border: none;
    color: #fff;
    border-radius: 8px;
    padding: 6px 14px;
    font-weight: 600;
    font-size: 0.98rem;
    display: flex;
    align-items: center;
    gap: 4px;
    box-shadow: 0 1px 4px 0 rgba(34, 197, 94, 0.08);
    transition: background 0.18s;
  }

  .modern-sales-table .btn-success:hover {
    background: #16a34a;
  }

  .custom-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(30, 41, 59, 0.18);
    justify-content: center;
    align-items: center;
  }

  .custom-modal.show {
    display: flex;
  }

  .custom-modal-content {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 32px 0 rgba(30, 41, 59, 0.18);
    width: 98vw;
    max-width: 480px;
    padding: 0;
    animation: modalIn 0.18s cubic-bezier(.4, 2, .6, 1) both;
  }

  @keyframes modalIn {
    from {
      transform: translateY(40px) scale(.98);
      opacity: 0;
    }

    to {
      transform: none;
      opacity: 1;
    }
  }

  .custom-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 22px 10px 22px;
    border-bottom: 1px solid #e2e8f0;
  }

  .custom-modal-title {
    font-weight: 700;
    font-size: 1.18rem;
    color: #1e293b;
  }

  .custom-modal-close {
    font-size: 1.6rem;
    color: #64748b;
    cursor: pointer;
    font-weight: bold;
    transition: color 0.2s;
  }

  .custom-modal-close:hover {
    color: #e11d48;
  }

  .custom-modal-body {
    padding: 18px 22px 18px 22px;
  }
</style>
<script>
  // Custom modal logic
  document.addEventListener('DOMContentLoaded', function() {
    var openBtn = document.getElementById('openSalesModal');
    var modal = document.getElementById('customSalesModal');
    var closeBtn = document.getElementById('closeSalesModal');
    openBtn.addEventListener('click', function() {
      modal.classList.add('show');
      loadSalesModal();
      document.getElementById('searchSales').value = '';
    });
    closeBtn.addEventListener('click', function() {
      modal.classList.remove('show');
    });
    window.addEventListener('click', function(e) {
      if (e.target === modal) modal.classList.remove('show');
    });
    // Load sales data ke tabel modal
    function loadSalesModal(keyword = '') {
      fetch('/webadmin/public/salesapi.php?search=' + encodeURIComponent(keyword))
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
    // Search sales di modal
    var searchSales = document.getElementById('searchSales');
    if (searchSales) {
      searchSales.addEventListener('input', function() {
        loadSalesModal(this.value);
      });
    }
    // Pilih sales dari modal
    document.body.addEventListener('click', function(e) {
      if (e.target.classList.contains('pilih-sales-btn')) {
        const kode = e.target.getAttribute('data-kode');
        const nama = e.target.getAttribute('data-nama');
        document.getElementById('salesInput').value = kode + ' - ' + nama;
        modal.classList.remove('show');
      }
    });
  });
</script>
<?= $this->endSection(); ?>