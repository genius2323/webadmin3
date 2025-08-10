<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="file-text"></i></div>
                        Data Penjualan
                    </h1>
                    <div class="small">Daftar seluruh transaksi penjualan.</div>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <?php if (isset($canCreate) ? $canCreate : true): ?>
                        <a class="btn btn-sm btn-primary" href="<?= site_url('penjualan/pos') ?>">
                            <i class="me-1" data-feather="plus"></i> Buat Nota Baru
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container-fluid px-4">
    <div class="card animate__animated animate__fadeInUp mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <form method="get" class="d-flex align-items-center gap-2 mb-0">
                    <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Cari nomor nota/customer/sales..." value="<?= esc($_GET['keyword'] ?? '') ?>" style="max-width:200px;">
                    <button type="submit" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center" title="Cari" style="height:32px; width:32px; padding:0;"><i data-feather="search"></i></button>
                    <?php if (!empty($_GET['keyword'])): ?>
                        <a href="<?= site_url('penjualan/datapenjualan') ?>" class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center" title="Clear" style="height:32px; width:32px; padding:0;"><i data-feather="x"></i></a>
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
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Nomor Nota</th>
                            <th style="text-align:center;">Tanggal</th>
                            <th style="text-align:center;">Customer</th>
                            <th style="text-align:center;">Sales</th>
                            <th style="text-align:center;">Total</th>
                            <th style="text-align:center;">Status</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (isset($pager) && $pager) {
                            $no = 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage());
                        }
                        if (!empty($penjualan)) :
                            foreach ($penjualan as $row) :
                                $otoritas = $row['otoritas'] ?? 'T'; ?>
                                <tr>
                                    <td style="text-align:center;"> <?= $no++ ?> </td>
                                    <td style="text-align:center;white-space:nowrap;"> <?= esc($row['nomor_nota']) ?> </td>
                                    <td style="text-align:center;white-space:nowrap;"> <?= esc(date('d/m/Y', strtotime($row['tanggal_nota']))) ?> </td>
                                    <td style="text-align:center;white-space:nowrap;"> <?= esc($row['customer']) ?> </td>
                                    <td style="text-align:center;white-space:nowrap;"> <?= esc($row['sales']) ?> </td>
                                    <td style="text-align:right;white-space:nowrap;">Rp <?= number_format($row['grand_total'], 0, ',', '.') ?> </td>
                                    <td style="text-align:center;">
                                        <span class="badge <?= $row['status'] == 'completed' ? 'bg-success' : 'bg-warning text-dark' ?>" style="border-radius:8px;">
                                            <?= esc(ucfirst($row['status'])) ?>
                                        </span>
                                    </td>
                                    <td class="text-center" style="white-space: nowrap !important;">
                                        <a href="<?= site_url('penjualan/detail/' . $row['id']) ?>" class="btn btn-sm btn-info" title="Detail"><i data-feather="eye"></i></a>
                                        <?php if ($otoritas === 'T'): ?>
                                            <a href="<?= site_url('penjualan/edit/' . $row['id']) ?>" class="btn btn-sm btn-warning" title="Edit"><i data-feather="edit"></i></a>
                                            <a href="<?= site_url('penjualan/delete/' . $row['id']) ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini? Data akan dihapus (soft delete) di dua database.')"><i data-feather="trash-2"></i></a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-warning" style="opacity:0.6;cursor:not-allowed; " disabled><i data-feather="edit"></i></button>
                                            <button class="btn btn-sm btn-danger" style="opacity:0.6;cursor:not-allowed;" disabled><i data-feather="trash-2"></i></button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach;
                        else : ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">Data tidak ditemukan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if (isset($pager)): ?>
                <div class="d-flex justify-content-center mt-4">
                    <?= $pager->links('default', 'modern_pager') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>