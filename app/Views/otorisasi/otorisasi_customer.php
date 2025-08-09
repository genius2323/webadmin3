<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="users"></i></div>
                        Otorisasi Customer
                    </h1>
                    <div class="small">Kelola otorisasi akses customer</div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container-fluid px-4">
    <?php if (session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="card mb-4 animate__animated animate__fadeInUp">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <form method="get" class="d-flex align-items-center gap-2 mb-0">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari customer..." value="<?= esc($search ?? '') ?>" style="max-width:180px;">
                    <button type="submit" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center" title="Cari" style="height:32px; width:32px; padding:0;"><i data-feather="search"></i></button>
                    <?php if (!empty($search)): ?>
                        <a href="<?= site_url('otorisasi/otorisasi_customer') ?>" class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center" title="Clear" style="height:32px; width:32px; padding:0;"><i data-feather="x"></i></a>
                    <?php endif; ?>
                </form>
                <form method="get" class="d-flex align-items-center gap-2 mb-0">
                    <select name="perPage" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <?php $perPage = (int)($_GET['perPage'] ?? 10); ?>
                        <?php foreach ([10, 25, 50, 100] as $opt): ?>
                            <option value="<?= $opt ?>" <?= $perPage === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="small ms-1">Per Halaman</span>
                </form>
            </div>
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
                </style>
                <table class="table table-bordered table-radius align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="text-align:center;">Kode</th>
                            <th style="text-align:center;">Nama</th>
                            <th style="text-align:center;">Alamat</th>
                            <th style="text-align:center;">Sales</th>
                            <th style="text-align:center;">Otoritas</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list as $customer): ?>
                            <tr>
                                <td><?= esc($customer['kode_customer'] ?? '') ?></td>
                                <td style="white-space:nowrap;"><?= esc($customer['nama_customer'] ?? '') ?></td>
                                <td style="white-space:nowrap; overflow-x:auto; max-width:220px;"><?= esc($customer['alamat'] ?? '') ?></td>
                                <td style="white-space:nowrap;"><?= esc($customer['sales'] ?? '') ?></td>
                                <td style="text-align:center;">
                                    <?php if (($customer['otoritas'] ?? '') === 'T'): ?>
                                        <span class="badge bg-success">Sudah Otorisasi</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Belum</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align:center;">
                                    <form action="<?= site_url('otorisasi/otorisasi_customer/setOtorisasiCustomer') ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="customer_id" value="<?= $customer['id'] ?>">
                                        <input type="hidden" name="otoritas" value="<?= ($customer['otoritas'] ?? '') === 'T' ? 'F' : 'T' ?>">
                                        <button type="submit" class="btn btn-sm btn-<?= ($customer['otoritas'] ?? '') === 'T' ? 'danger' : 'success' ?>">
                                            <?= ($customer['otoritas'] ?? '') === 'T' ? 'Nonaktifkan' : 'Otorisasi' ?>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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
</div>
</div>
<?= $this->endSection() ?>