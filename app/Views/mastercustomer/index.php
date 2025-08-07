<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>


<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="users"></i></div>
                        Master Customer
                    </h1>
                    <div class="small">Kelola seluruh data customer di sini.</div>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-primary" href="<?= site_url('mastercustomer/create') ?>">
                        <i class="me-1" data-feather="plus"></i> Tambah
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container-fluid px-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <form method="get" class="d-flex align-items-center gap-2 mb-0">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari customer..." value="<?= esc($search ?? '') ?>" style="max-width:180px;">
                    <button type="submit" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center" title="Cari" style="height:32px; width:32px; padding:0;"><i data-feather="search"></i></button>
                    <?php if (!empty($search)): ?>
                        <a href="<?= site_url('mastercustomer') ?>" class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center" title="Clear" style="height:32px; width:32px; padding:0;"><i data-feather="x"></i></a>
                    <?php endif; ?>
                </form>
                <form method="get" class="d-flex align-items-center gap-2 mb-0">
                    <select name="perPage" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <?php $perPage = (int)($perPage ?? 10); ?>
                        <?php foreach ([10, 25, 50, 100] as $opt): ?>
                            <option value="<?= $opt ?>" <?= $perPage === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="small ms-1">Per Halaman</span>
                </form>
            </div>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i data-feather="check-circle" class="me-1"></i>
                    <?= esc(session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <style>
                    .table-radius {
                        border-radius: 8px;
                        border-collapse: separate !important;
                        border-spacing: 0;
                        overflow: hidden;
                    }

                    .table-radius th:first-child {
                        border-top-left-radius: 8px;
                    }

                    .table-radius th:last-child {
                        border-top-right-radius: 8px;
                    }

                    .table-radius tr:last-child td:first-child {
                        border-bottom-left-radius: 8px;
                    }

                    .table-radius tr:last-child td:last-child {
                        border-bottom-right-radius: 8px;
                    }

                    .table-radius th,
                    .table-radius td {
                        border: 1.5px solid #dee2e6;
                    }

                    .table-radius th:first-child {
                        border-left-width: 1.5px;
                    }

                    .table-radius th:last-child {
                        border-right-width: 1.5px;
                    }

                    .table-radius tr:last-child td:first-child {
                        border-left-width: 1.5px;
                    }

                    .table-radius tr:last-child td:last-child {
                        border-right-width: 1.5px;
                    }

                    .table-radius tr:first-child th {
                        border-top-width: 1.5px;
                    }

                    .table-radius tr:last-child td {
                        border-bottom-width: 1.5px;
                    }
                </style>
                <table class="table table-bordered table-hover align-middle mb-0 table-radius">
                    <thead class="table-light">
                        <tr>
                            <th style="text-align:center;white-space:nowrap;">No</th>
                            <th style="text-align:center;white-space:nowrap;">Kode</th>
                            <th style="text-align:center;white-space:nowrap;">Nama</th>
                            <th style="text-align:center;white-space:nowrap;">Alamat</th>
                            <th style="text-align:center;white-space:nowrap;">Contact Person</th>
                            <th style="text-align:center;white-space:nowrap;">Kota</th>
                            <th style="text-align:center;white-space:nowrap;">Provinsi</th>
                            <th style="text-align:center;white-space:nowrap;">Sales</th>
                            <th style="text-align:center;white-space:nowrap;">No HP</th>
                            <th style="text-align:center;white-space:nowrap;">Batas Piutang</th>
                            <th style="text-align:center;white-space:nowrap;">NPWP</th>
                            <th style="text-align:center;white-space:nowrap;">Otoritas</th>
                            <th style="text-align:center;white-space:nowrap;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (isset($pager) && $pager) {
                            $no = 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage());
                        }
                        if (!empty($customers)) :
                            foreach ($customers as $row) : ?>
                                <tr>
                                    <td style="text-align:center;"> <?= $no++ ?> </td>
                                    <td style="white-space: nowrap !important;"><?= esc($row['kode_customer']) ?></td>
                                    <td style="white-space: nowrap !important;"><?= esc($row['nama_customer']) ?></td>
                                    <td><?= esc($row['alamat']) ?></td>
                                    <td style="white-space: nowrap !important;"><?= esc($row['contact_person']) ?></td>
                                    <td><?= esc($row['kota']) ?></td>
                                    <td><?= esc($row['provinsi']) ?></td>
                                    <td style="white-space:nowrap;"><?= esc($row['sales']) ?></td>
                                    <td><?= esc($row['no_hp']) ?></td>
                                    <td style="white-space: nowrap !important;text-align:right;">Rp <?= number_format($row['batas_piutang'], 0, ',', '.') ?></td>
                                    <td><?= esc($row['npwp_nomor']) ?></td>
                                    <td style="text-align:center;">
                                        <?php if (!empty($row['otoritas']) && $row['otoritas'] === 'T'): ?>
                                            <span class="badge bg-success">Sudah Otorisasi</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Belum Otorisasi</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center" style="white-space: nowrap !important;">
                                        <?php if (!empty($row['otoritas']) && $row['otoritas'] === 'T'): ?>
                                            <a href="<?= site_url('mastercustomer/edit/' . $row['id']) ?>" class="btn btn-sm btn-warning"><i data-feather="edit"></i></a>
                                            <button type="button" class="btn btn-sm btn-danger btn-hapus-customer" data-id="<?= $row['id'] ?>" data-nama="<?= esc($row['nama_customer']) ?>"><i data-feather="trash-2"></i></button>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-warning" style="opacity:0.6;cursor:not-allowed; " disabled><i data-feather="edit"></i></button>
                                            <button class="btn btn-sm btn-danger" style="opacity:0.6;cursor:not-allowed;" disabled><i data-feather="trash-2"></i></button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <!-- Modal Hapus Customer SBAdmin -->
                                <div class="modal fade" id="modalHapusCustomer" tabindex="-1" aria-labelledby="modalHapusCustomerLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="modalHapusCustomerLabel"><i data-feather="trash-2"></i> Konfirmasi Hapus Customer</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin menghapus customer <span id="hapusCustomerNama" class="fw-bold text-danger"></span>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <a href="#" id="btnConfirmHapusCustomer" class="btn btn-danger">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        let hapusId = null;
                                        let hapusNama = '';
                                        const modalEl = document.getElementById('modalHapusCustomer');
                                        const hapusCustomerNama = document.getElementById('hapusCustomerNama');
                                        const btnConfirmHapusCustomer = document.getElementById('btnConfirmHapusCustomer');
                                        document.querySelectorAll('.btn-hapus-customer').forEach(function(btn) {
                                            btn.addEventListener('click', function() {
                                                hapusId = this.getAttribute('data-id');
                                                hapusNama = this.getAttribute('data-nama');
                                                hapusCustomerNama.textContent = hapusNama;
                                                btnConfirmHapusCustomer.setAttribute('href', '<?= site_url('mastercustomer/delete/') ?>' + hapusId);
                                                var modal = new bootstrap.Modal(modalEl);
                                                modal.show();
                                            });
                                        });
                                    });
                                </script>
                            <?php endforeach;
                        else : ?>
                            <tr>
                                <td colspan="13" class="text-center text-muted">Data tidak ditemukan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if (!empty($pager)): ?>
                <div class="d-flex justify-content-center mt-4">
                    <?= $pager->links('default', 'modern_pager') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if (!empty($pager)): ?>
    <style>
        .pagination-modern-container {
            display: flex;
            justify-content: center;
            margin: 1.5rem 0 0.5rem 0;
        }

        .pagination-modern {
            display: flex;
            gap: 4px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            padding: 6px 16px;
        }

        .pagination-modern li {
            list-style: none;
        }

        .pagination-modern a,
        .pagination-modern span {
            display: block;
            min-width: 32px;
            padding: 6px 10px;
            border-radius: 6px;
            color: #333;
            background: none;
            text-align: center;
            text-decoration: none !important;
            font-weight: 500;
            transition: background 0.15s, color 0.15s;
        }

        .pagination-modern .active span,
        .pagination-modern a:hover {
            background: #4285F4;
            color: #fff;
        }

        .pagination-modern .disabled span {
            color: #bbb;
            background: #f5f5f5;
        }
    </style>
<?php endif; ?>

<?= $this->endSection() ?>