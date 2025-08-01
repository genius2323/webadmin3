<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="eye"></i></div>
                            Master Jumlah Mata
                        </h1>
                        <div class="small">Kelola seluruh data jumlah mata di sini.</div>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-primary" href="<?= site_url('masterjumlahmata/create') ?>">
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
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari jumlah mata..." value="<?= esc($search ?? '') ?>" style="max-width:180px;">
                        <button type="submit" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center" title="Cari" style="height:32px; width:32px; padding:0;"><i data-feather="search"></i></button>
                        <?php if (!empty($search)): ?>
                            <a href="<?= site_url('masterjumlahmata') ?>" class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center" title="Clear" style="height:32px; width:32px; padding:0;"><i data-feather="x"></i></a>
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

                        /* Sudut border tabel */
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

                        /* Border pada th dan td agar radius terlihat */
                        .table-radius th,
                        .table-radius td {
                            border: 1.5px solid #dee2e6;
                        }

                        /* Hilangkan border double di sudut */
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
                                <th style="text-align:center;">No</th>
                                <th style="text-align:center;">Nama</th>
                                <th style="text-align:center;">Deskripsi</th>
                                <th style="text-align:center;">Otoritas</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($jumlahmata)): ?>
                                <?php foreach ($jumlahmata as $i => $row): ?>
                                    <tr>
                                        <td style="text-align:center;"> <?= ($perPage * (($_GET['page_default'] ?? 1) - 1)) + $i + 1 ?> </td>
                                        <td><?= esc($row['name']) ?></td>
                                        <td><?= esc($row['description'] ?? '-') ?></td>
                                        <td style="text-align:center;">
                                            <?php if ($row['otoritas'] === 'T'): ?>
                                                <span class="badge bg-success">Sudah Otorisasi</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Belum Otorisasi</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center" style="white-space: nowrap !important;">
                                            <?php if (!empty($row['otoritas']) && $row['otoritas'] === 'T'): ?>
                                                <a href="<?= site_url('masterjumlahmata/edit/' . $row['id']) ?>" class="btn btn-sm btn-warning"><i data-feather="edit"></i></a>
                                                <a href="<?= site_url('masterjumlahmata/delete/' . $row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')"><i data-feather="trash-2"></i></a>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-warning" style="opacity:0.6;cursor:not-allowed; " disabled><i data-feather="edit"></i></button>
                                                <button class="btn btn-sm btn-danger" style="opacity:0.6;cursor:not-allowed;" disabled><i data-feather="trash-2"></i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Data tidak ditemukan</td>
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
</main>
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <span class="material-symbols-outlined alert-icon">check_circle</span>
        <span><?= esc(session()->getFlashdata('success')) ?></span>
        <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
    </div>
<?php endif; ?>
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