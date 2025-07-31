<?php
// View: app/Views/otorisasi_klasifikasi/otorisasi_dimensi.php
?>

<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <!-- Dropdown menu animasi fadeInUp -->
    <div class="mb-4" style="max-width:200px; margin-top:32px;">
        <div class="dropdown animate__animated animate__fadeInUp shadow-lg">
            <button class="btn btn-primary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Menu Klasifikasi
            </button>
            <ul class="dropdown-menu animate__animated animate__fadeInUp shadow-lg w-100" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_kategori' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_kategori') ?>">Master Kategori</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_daya' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_daya') ?>">Master Daya</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_dimensi' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_dimensi') ?>">Master Dimensi</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_fiting' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_fiting') ?>">Master Fiting</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_gondola' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_gondola') ?>">Master Gondola</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_jenis' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_jenis') ?>">Master Jenis</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_jumlahmata' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_jumlahmata') ?>">Master Jumlahmata</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_kaki' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_kaki') ?>">Master Kaki</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_merk' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_merk') ?>">Master Merk</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_model' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_model') ?>">Master Model</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_pelengkap' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_pelengkap') ?>">Master Pelengkap</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_satuan' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_satuan') ?>">Master Satuan</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_ukuranbarang' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_ukuranbarang') ?>">Master Ukuranbarang</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_voltase' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_voltase') ?>">Master Voltase</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_warnabibir' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_warnabibir') ?>">Master Warnabibir</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_warnabody' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_warnabody') ?>">Master Warnabody</a></li>
                <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_warnasinar' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_warnasinar') ?>">Master Warnasinar</a></li>
            </ul>
        </div>
    </div>
    <?php if (session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="mb-3">Otorisasi Dimensi</h4>
            <form class="row g-2 mb-3" method="get" action="">
                <div class="col-auto">
                    <input type="text" name="q" class="form-control" placeholder="Cari dimensi..." value="<?= esc($q ?? '') ?>">
                </div>
                <div class="col-auto">
                    <select name="per_page" class="form-select">
                        <?php foreach ([5, 10, 20, 50, 100] as $opt): ?>
                            <option value="<?= $opt ?>" <?= (isset($perPage) && $perPage == $opt) ? ' selected' : '' ?>><?= $opt ?>/halaman</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-secondary">Terapkan</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Nama Dimensi</th>
                            <th style="text-align:center;">Status Otorisasi</th>
                            <th style="text-align:center;">Aksi Otorisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($dimensis)): ?>
                            <?php foreach ($dimensis as $i => $dimensi): ?>
                                <tr>
                                    <td style="text-align:center;"> <?= ($pager->getCurrentPage() - 1) * $pager->getPerPage() + $i + 1 ?> </td>
                                    <td><?= esc($dimensi['name']) ?></td>
                                    <td style="text-align:center;">
                                        <?php if (($dimensi['otoritas'] ?? null) === 'T'): ?>
                                            <span class="badge bg-success">Sudah Diotorisasi</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Belum</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align:center;">
                                        <form method="post" action="<?= site_url('otorisasi_klasifikasi/otorisasi_dimensi/setOtorisasiDimensi') ?>">
                                            <input type="hidden" name="dimensi_id" value="<?= $dimensi['id'] ?>">
                                            <input type="hidden" name="otoritas" value="<?= ($dimensi['otoritas'] ?? null) === 'T' ? 'F' : 'T' ?>">
                                            <button type="submit" class="btn btn-sm <?= ($dimensi['otoritas'] ?? null) === 'T' ? 'btn-danger' : 'btn-success' ?>">
                                                <?= ($dimensi['otoritas'] ?? null) === 'T' ? 'Nonaktifkan' : 'Otorisasi' ?>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data dimensi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <?= $pager->links() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>