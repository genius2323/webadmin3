<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
  <div class="col-md-7">
    <div class="card animate__animated animate__fadeInUp mb-4 shadow-sm border-0 mt-4">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="fa fa-shopping-cart me-2"></i> Tambah Penjualan</h4>
      </div>
      <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')): ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach (session('errors') as $err): ?>
                <li><?= esc($err) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
        <form action="<?= base_url('penjualan/create') ?>" method="post" autocomplete="off">
          <div class="mb-3">
            <?php
            $minDate = '';
            $maxDate = '';
            if (($mode_batas_tanggal ?? 'manual') === 'automatic') {
              $maxDate = date('Y-m-d');
              $minDate = date('Y-m-d', strtotime('-2 days'));
            } elseif (!empty($batas_tanggal_sistem)) {
              $minDate = $batas_tanggal_sistem;
              $maxDate = date('Y-m-d');
            }
            ?>
            <input type="text" name="tanggal_nota" id="tanggal_nota" class="form-control"
              style="background:#f8f9fa; cursor:pointer; color:#212529;"
              value="<?= (isset($penjualan) && isset($penjualan['tanggal_nota'])) ? date('d/m/Y', strtotime($penjualan['tanggal_nota'])) : date('d/m/Y') ?>"
              required readonly>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
            <script>
              document.addEventListener('DOMContentLoaded', function() {
                flatpickr('#tanggal_nota', {
                  dateFormat: 'd/m/Y',
                  disableMobile: true,
                  minDate: <?= $minDate ? "'" . date('d/m/Y', strtotime($minDate)) . "'" : 'null' ?>,
                  maxDate: <?= $maxDate ? "'" . date('d/m/Y', strtotime($maxDate)) . "'" : 'null' ?>,
                  allowInput: false
                });
              });
            </script>
            <input type="hidden" id="mode_batas_tanggal" name="mode_batas_tanggal" value="<?= esc($mode_batas_tanggal ?? 'manual') ?>">
            <input type="hidden" id="batas_tanggal_sistem" name="batas_tanggal_sistem" value="<?= esc($batas_tanggal_sistem ?? '') ?>">
          </div>
          <div class="mb-3">
            <label for="nomor_nota" class="form-label">Nomor Nota</label>
            <input type="text" class="form-control" id="nomor_nota"
              placeholder="<?= esc($nomor_nota ?? '-') ?>"
              readonly style="background:#f8f9fa; cursor:not-allowed;">
            <input type="hidden" name="nomor_nota" value="<?= esc($nomor_nota ?? '') ?>">
          </div>
          <div class="mb-3">
            <label for="customer" class="form-label">Customer</label>
            <div class="input-group">
              <input type="text" class="form-control" id="customerInput" name="customer" readonly>
              <div class="input-group-append">
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCustomer">Pilih Customer</button>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="sales" class="form-label">Sales</label>
            <div class="input-group">
              <input type="text" class="form-control" id="salesInput" name="sales" readonly>
              <div class="input-group-append">
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalSales">Pilih Sales</button>
              </div>
            </div>
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-plus me-2"></i> Tambah Penjualan</button>
          </div>
          <!-- Modal Pilih Customer -->
          <style>
            /* Konsisten margin top semua modal penjualan */
            .modal-dialog {
              margin-top: 70px;
            }

            @media (max-width: 576px) {
              .modal-dialog {
                margin-top: 30px;
              }
            }
          </style>
          <div class="modal fade" id="modalCustomer" tabindex="-1" aria-labelledby="modalCustomerLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCustomerLabel">Pilih Customer</h5>
                  <!-- tombol close dihapus agar konsisten -->
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <input type="text" id="searchCustomer" class="form-control" placeholder="Cari">
                  </div>
                  <div class="table-responsive" style="overflow-x:auto;max-width:100vw;">
                    <table class="table table-bordered table-hover" id="tableCustomerModal">
                      <thead>
                        <tr>
                          <th>Kode</th>
                          <th>Nama</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($customers as $row): ?>
                          <tr>
                            <td><?= esc($row['kode_customer']) ?></td>
                            <td><?= esc($row['nama_customer']) ?></td>
                            <td><button type="button" class="btn btn-success btn-sm pilih-customer-btn" data-kode="<?= esc($row['kode_customer']) ?>" data-nama="<?= esc($row['nama_customer']) ?>">Pilih</button></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Pilih Customer -->
          <div class="modal fade" id="modalCustomer" tabindex="-1" aria-labelledby="modalCustomerLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCustomerLabel">Pilih Customer</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="form-group mb-3">
                    <input type="text" id="searchCustomer" class="form-control" placeholder="Cari Customer...">
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tableCustomerModal">
                      <thead>
                        <tr>
                          <th>Kode</th>
                          <th>Nama</th>
                          <th class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($customers as $row): ?>
                          <tr>
                            <td><?= esc($row['kode_customer']) ?></td>
                            <td><?= esc($row['nama_customer']) ?></td>
                            <td class="text-center"><button type="button" class="btn btn-success btn-sm pilih-customer-btn" data-kode="<?= esc($row['kode_customer']) ?>" data-nama="<?= esc($row['nama_customer']) ?>"><i class="fa fa-check"></i> Pilih</button></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal Pilih Sales -->
          <div class="modal fade" id="modalSales" tabindex="-1" aria-labelledby="modalSalesLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalSalesLabel">Pilih Sales</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="form-group mb-3">
                    <input type="text" id="searchSales" class="form-control" placeholder="Cari Sales...">
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tableSalesModal">
                      <thead>
                        <tr>
                          <th>Kode</th>
                          <th>Nama</th>
                          <th class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($sales as $row): ?>
                          <tr>
                            <td><?= esc($row['kode']) ?></td>
                            <td><?= esc($row['nama']) ?></td>
                            <td class="text-center"><button type="button" class="btn btn-success btn-sm pilih-sales-btn" data-kode="<?= esc($row['kode']) ?>" data-nama="<?= esc($row['nama']) ?>"><i class="fa fa-check"></i> Pilih</button></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>

          </script>
          <!-- Modal Pilih Customer -->
          <div class="modal fade bd-example-modal-md" id="modalCustomer" tabindex="-1" role="dialog" aria-labelledby="modalCustomerLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCustomerLabel">Pilih Customer</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <input type="text" id="searchCustomer" class="form-control" placeholder="Cari">
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tableCustomerModal">
                      <thead>
                        <tr>
                          <th>Kode</th>
                          <th>Nama</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($customers as $row): ?>
                          <tr>
                            <td><?= esc($row['kode_customer']) ?></td>
                            <td><?= esc($row['nama_customer']) ?></td>
                            <td><button type="button" class="btn btn-success btn-sm pilih-customer-btn" data-kode="<?= esc($row['kode_customer']) ?>" data-nama="<?= esc($row['nama_customer']) ?>">Pilih</button></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Pilih Sales -->
          <div class="modal fade" id="modalSales" tabindex="-1" aria-labelledby="modalSalesLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalSalesLabel">Pilih Sales</h5>
                  <!-- tombol close dihapus agar konsisten -->
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <input type="text" id="searchSales" class="form-control" placeholder="Cari">
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tableSalesModal">
                      <thead>
                        <tr>
                          <th>Kode</th>
                          <th>Nama</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($sales as $row): ?>
                          <tr>
                            <td><?= esc($row['kode']) ?></td>
                            <td><?= esc($row['nama']) ?></td>
                            <td><button type="button" class="btn btn-success btn-sm pilih-sales-btn" data-kode="<?= esc($row['kode']) ?>" data-nama="<?= esc($row['nama']) ?>">Pilih</button></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>

          <script>
            $(document).ready(function() {
              // Modal Customer
              function filterCustomer(keyword = '') {
                $('#tableCustomerModal tbody tr').each(function() {
                  var nama = $(this).find('td:nth-child(2)').text().toLowerCase();
                  var kode = $(this).find('td:nth-child(1)').text().toLowerCase();
                  if (nama.indexOf(keyword.toLowerCase()) !== -1 || kode.indexOf(keyword.toLowerCase()) !== -1) {
                    $(this).show();
                  } else {
                    $(this).hide();
                  }
                });
              }
              $('#searchCustomer').on('input', function() {
                filterCustomer($(this).val());
              });
              $(document.body).on('click', '.pilih-customer-btn', function() {
                var kode = $(this).data('kode');
                var nama = $(this).data('nama');
                $('#customerInput').val(kode + ' - ' + nama);
                $('#modalCustomer').modal('hide');
              });

              // Modal Sales
              function filterSales(keyword = '') {
                $('#tableSalesModal tbody tr').each(function() {
                  var nama = $(this).find('td:nth-child(2)').text().toLowerCase();
                  var kode = $(this).find('td:nth-child(1)').text().toLowerCase();
                  if (nama.indexOf(keyword.toLowerCase()) !== -1 || kode.indexOf(keyword.toLowerCase()) !== -1) {
                    $(this).show();
                  } else {
                    $(this).hide();
                  }
                });
              }
              $('#searchSales').on('input', function() {
                filterSales($(this).val());
              });
              $(document.body).on('click', '.pilih-sales-btn', function() {
                var kode = $(this).data('kode');
                var nama = $(this).data('nama');
                $('#salesInput').val(kode + ' - ' + nama);
                $('#modalSales').modal('hide');
              });
            });
          </script>
          <script>
            // Search filter Customer
            document.addEventListener('DOMContentLoaded', function() {
              var searchCustomer = document.getElementById('searchCustomer');
              if (searchCustomer) {
                searchCustomer.addEventListener('input', function() {
                  var filter = searchCustomer.value.toLowerCase();
                  var rows = document.querySelectorAll('#tableCustomerModal tbody tr');
                  rows.forEach(function(row) {
                    var nama = row.cells[1].textContent.toLowerCase();
                    var kode = row.cells[0].textContent.toLowerCase();
                    row.style.display = (nama.indexOf(filter) > -1 || kode.indexOf(filter) > -1) ? '' : 'none';
                  });
                });
              }
              // Pilih Customer
              document.body.addEventListener('click', function(e) {
                if (e.target.classList.contains('pilih-customer-btn')) {
                  var kode = e.target.getAttribute('data-kode');
                  var nama = e.target.getAttribute('data-nama');
                  var input = document.getElementById('customerInput');
                  if (input) input.value = kode + ' - ' + nama;
                  var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalCustomer'));
                  modal.hide();
                }
              });
              // Search filter Sales
              var searchSales = document.getElementById('searchSales');
              if (searchSales) {
                searchSales.addEventListener('input', function() {
                  var filter = searchSales.value.toLowerCase();
                  var rows = document.querySelectorAll('#tableSalesModal tbody tr');
                  rows.forEach(function(row) {
                    var nama = row.cells[1].textContent.toLowerCase();
                    var kode = row.cells[0].textContent.toLowerCase();
                    row.style.display = (nama.indexOf(filter) > -1 || kode.indexOf(filter) > -1) ? '' : 'none';
                  });
                });
              }
              // Pilih Sales
              document.body.addEventListener('click', function(e) {
                if (e.target.classList.contains('pilih-sales-btn')) {
                  var kode = e.target.getAttribute('data-kode');
                  var nama = e.target.getAttribute('data-nama');
                  var input = document.getElementById('salesInput');
                  if (input) input.value = kode + ' - ' + nama;
                  var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalSales'));
                  modal.hide();
                }
              });
            });
          </script>
          <!-- Modal Pilih Customer -->
          <div class="modal fade" id="modalCustomer" tabindex="-1" aria-labelledby="modalCustomerLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCustomerLabel">Pilih Customer</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($customers as $row): ?>
                        <tr>
                          <td><?= esc($row['kode_customer']) ?></td>
                          <td><?= esc($row['nama_customer']) ?></td>
                          <td><button type="button" class="btn btn-success btn-sm" onclick="pilihCustomer('<?= esc($row['kode_customer']) ?>', '<?= esc($row['nama_customer']) ?>')">Pilih</button></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal Pilih Sales -->
          <div class="modal fade" id="modalSales" tabindex="-1" aria-labelledby="modalSalesLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalSalesLabel">Pilih Sales</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($sales as $row): ?>
                        <tr>
                          <td><?= esc($row['kode']) ?></td>
                          <td><?= esc($row['nama']) ?></td>
                          <td><button type="button" class="btn btn-success btn-sm" onclick="pilihSales('<?= esc($row['kode']) ?>', '<?= esc($row['nama']) ?>')">Pilih</button></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <script>
            function pilihCustomer(kode, nama) {
              document.getElementById('customer').value = kode + ' - ' + nama;
              var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalCustomer'));
              modal.hide();
            }

            function pilihSales(kode, nama) {
              document.getElementById('sales').value = kode + ' - ' + nama;
              var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalSales'));
              modal.hide();
            }
          </script>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>