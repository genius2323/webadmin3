<?php
// View: app/Views/otorisasi_klasifikasi/otorisasi_kategori.php
?>

<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <?= view('otorisasi_klasifikasi/menu_klasifikasi') ?>
    <?php if (session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="card animate__animated animate__fadeInUp mb-4">
        <div class="card-body">
            <h4 class="mb-3">Otorisasi Kategori</h4>
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <form method="get" class="d-flex align-items-center gap-2 mb-0">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari kategori..." value="<?= esc($search ?? '') ?>" style="max-width:180px;">
                    <button type="submit" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center" title="Cari" style="height:32px; width:32px; padding:0;"><i data-feather="search"></i></button>
                    <?php if (!empty($search)): ?>
                        <a href="<?= site_url('otorisasi_klasifikasi/otorisasi_kategori') ?>" class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center" title="Clear" style="height:32px; width:32px; padding:0;"><i data-feather="x"></i></a>
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
                            <th style="text-align:center;">Nama Kategori</th>
                            <th style="text-align:center;">Status Otorisasi</th>
                            <th style="text-align:center;">Aksi Otorisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $i => $cat): ?>
                                <tr>
                                    <td style="text-align:center;"> <?= ($pager->getCurrentPage() - 1) * $pager->getPerPage() + $i + 1 ?> </td>
                                    <td><?= esc($cat['name']) ?></td>
                                    <td style="text-align:center;">
                                        <?php if (($cat['otoritas'] ?? null) === 'T'): ?>
                                            <span class="badge bg-success">Sudah Diotorisasi</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Belum</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align:center;">
                                        <form method="post" action="<?= site_url('otorisasi_klasifikasi/otorisasi_kategori/setOtorisasiKategori') ?>">
                                            <input type="hidden" name="kategori_id" value="<?= $cat['id'] ?>">
                                            <input type="hidden" name="otoritas" value="<?= ($cat['otoritas'] ?? null) === 'T' ? 'F' : 'T' ?>">
                                            <button type="submit" class="btn btn-sm <?= ($cat['otoritas'] ?? null) === 'T' ? 'btn-danger' : 'btn-success' ?>">
                                                <?= ($cat['otoritas'] ?? null) === 'T' ? 'Nonaktifkan' : 'Otorisasi' ?>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data kategori.</td>
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
</div>
</div>

<?= $this->endSection() ?>