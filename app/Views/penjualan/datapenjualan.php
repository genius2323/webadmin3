<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Header & Deskripsi -->
<div class="page-header" style="display:flex;align-items:center;gap:16px;margin-left:24px;margin-bottom:18px;">
    <div class="page-header-icon" style="display:flex;align-items:center;">
        <span class="material-symbols-outlined" style="font-size:2.2rem;">receipt_long</span>
    </div>
    <div>
        <h1 class="page-header-title" style="margin:0;">Data Penjualan</h1>
        <p class="page-header-subtitle" style="margin:0;">Daftar seluruh transaksi penjualan.</p>
    </div>
</div>
<div class="content-card">
    <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; margin-bottom: 20px;">
        <form method="get" style="display: flex; gap: 6px; align-items: center;">
            <input type="text" name="keyword" class="input-m3-date" placeholder="Cari nomor nota/customer/sales..." value="<?= esc($_GET['keyword'] ?? '') ?>" style="height:32px; font-size:0.95rem; padding:6px 10px; border-radius:8px;">
            <button type="submit" class="btn-m3 btn-m3-sm" style="height:32px; min-width:32px; padding:6px 10px; border-radius:8px;" title="Cari"><span class="material-symbols-outlined" style="font-size:18px;">search</span></button>
        </form>
        <?php if (isset($canCreate) ? $canCreate : true): ?>
        <a href="<?= site_url('penjualan') ?>" class="btn-m3 btn-m3-sm" style="height:32px; min-width:32px; padding:6px 10px; border-radius:8px; text-decoration:none;">
            <span class="material-symbols-outlined" style="vertical-align: middle; font-size:18px;">add</span>
            <span style="font-size:0.95rem;">Buat Nota Baru</span>
        </a>
        <?php endif; ?>
    </div>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <span class="material-symbols-outlined alert-icon">check_circle</span>
            <span><?= esc(session()->getFlashdata('success')) ?></span>
            <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    <?php endif; ?>
    <div class="table-responsive">
        <table class="table-m3">
            <thead>
                <tr>
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
                <?php foreach ($penjualan as $row): ?>
                    <?php $otoritas = $row['otoritas'] ?? 'T'; ?>
                    <tr>
                        <td style="text-align:center;white-space:nowrap;"> <?= esc($row['nomor_nota']) ?> </td>
                        <td style="text-align:center;white-space:nowrap;"> <?= esc(date('d/m/Y', strtotime($row['tanggal_nota']))) ?> </td>
                        <td style="text-align:center;white-space:nowrap;"> <?= esc($row['customer']) ?> </td>
                        <td style="text-align:center;white-space:nowrap;"> <?= esc($row['sales']) ?> </td>
                        <td style="text-align:center;white-space:nowrap;">Rp <?= number_format($row['grand_total'], 0, ',', '.') ?> </td>
                        <td style="text-align:center;">
                            <span class="badge-modern <?= $row['status'] == 'completed' ? 'badge-success-modern' : 'badge-warning-modern' ?>" style="border-radius:8px;">
                                <?= esc(ucfirst($row['status'])) ?>
                            </span>
                        </td>
                        <td style="min-width:80px;display:flex;gap:4px;justify-content:center;align-items:center;">
                            <?php if ($otoritas === 'T'): ?>
                                <a href="<?= site_url('penjualan/detail/' . $row['id']) ?>" class="btn-m3 btn-m3-sm btn-m3-secondary" style="height:28px; min-width:28px; padding:4px 8px; border-radius:8px; text-decoration:none; background:#90CAF9; color:#fff;">
                                    <span class="material-symbols-outlined" style="font-size:16px;">visibility</span>
                                </a>
                                <a href="<?= site_url('penjualan/edit/' . $row['id']) ?>" class="btn-m3 btn-m3-sm btn-m3-warning" style="height:28px; min-width:28px; padding:4px 8px; border-radius:8px; text-decoration:none; background:#FFD600; color:#333;">
                                    <span class="material-symbols-outlined" style="font-size:16px;">edit</span>
                                </a>
                                <a href="<?= site_url('penjualan/delete/' . $row['id']) ?>" class="btn-m3 btn-m3-sm btn-m3-danger" style="height:28px; min-width:28px; padding:4px 8px; border-radius:8px; text-decoration:none; background:#e53935; color:#fff;" onclick="return confirm('Yakin ingin menghapus data ini? Data akan dihapus (soft delete) di dua database.')">
                                    <span class="material-symbols-outlined" style="font-size:16px;">delete</span>
                                </a>
                            <?php else: ?>
                                <span class="btn-m3 btn-m3-sm btn-m3-warning" style="height:28px; min-width:28px; padding:4px 8px; border-radius:8px; background:#FFD600; color:#333; opacity:0.6; cursor:not-allowed; display:inline-flex; align-items:center; justify-content:center;">
                                    <span class="material-symbols-outlined" style="font-size:16px;">edit</span>
                                </span>
                                <span class="btn-m3 btn-m3-sm btn-m3-danger" style="height:28px; min-width:28px; padding:4px 8px; border-radius:8px; background:#e53935; color:#fff; opacity:0.6; cursor:not-allowed; display:inline-flex; align-items:center; justify-content:center;">
                                    <span class="material-symbols-outlined" style="font-size:16px;">delete</span>
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
<div class="card-m3">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert-m3 alert-m3-success mb-3 text-center">
            <span class="material-symbols-rounded align-middle">check_circle</span>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <!-- Form Pencarian -->
    <form method="get" action="" class="form-search-m3 mb-3 d-flex" style="gap:8px;">
        <input type="text" name="keyword" class="input-m3" placeholder="Cari nomor nota/customer/sales..." value="<?= esc($_GET['keyword'] ?? '') ?>" style="border-radius:8px;">
        <button type="submit" class="btn-m3 btn-secondary-m3 btn-m3-sm" style="border-radius:8px;">Cari</button>
    </form>
    <!-- Tabel Data Penjualan -->
    <div class="table-responsive-m3">
        <table class="table-m3">
            <thead>
                <tr>
                    <th class="text-center">Nomor Nota</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Customer</th>
                    <th class="text-center">Sales</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($penjualan as $row): ?>
                    <?php $otoritas = $row['otoritas'] ?? 'T'; ?>
                    <tr>
                        <td class="text-center" style="white-space:nowrap;"><?= esc($row['nomor_nota']) ?></td>
                        <td class="text-center" style="white-space:nowrap;"><?= esc(date('d/m/Y', strtotime($row['tanggal_nota']))) ?></td>
                        <td class="text-center" style="white-space:nowrap;"><?= esc($row['customer']) ?></td>
                        <td class="text-center" style="white-space:nowrap;"><?= esc($row['sales']) ?></td>
                        <td class="text-center" style="white-space:nowrap;">Rp <?= number_format($row['grand_total'], 0, ',', '.') ?></td>
                        <td class="text-center">
                            <span class="badge-modern <?= $row['status'] == 'completed' ? 'badge-success-modern' : 'badge-warning-modern' ?>" style="border-radius:8px;">
                                <?= esc(ucfirst($row['status'])) ?>
                            </span>
                        </td>
                        <td class="text-center" style="min-width:120px;display:flex;gap:6px;justify-content:center;align-items:center;">
                            <a href="<?= site_url('penjualan/detail/' . $row['id']) ?>" class="btn-m3 btn-secondary-m3 btn-m3-sm" title="Detail" style="border-radius:8px;">
                                <span class="material-symbols-rounded align-middle">visibility</span>
                            </a>
                            <?php if ($otoritas === 'T'): ?>
                                <a href="<?= site_url('penjualan/edit/' . $row['id']) ?>" class="btn-m3 btn-warning-m3 btn-m3-sm" title="Edit" style="border-radius:8px;">
                                    <span class="material-symbols-rounded align-middle">edit</span>
                                </a>
                                <a href="<?= site_url('penjualan/delete/' . $row['id']) ?>" class="btn-m3 btn-danger-m3 btn-m3-sm" title="Hapus" style="border-radius:8px;" onclick="return confirm('Yakin ingin menghapus data ini? Data akan dihapus (soft delete) di dua database.')">
                                    <span class="material-symbols-rounded align-middle">delete</span>
                                </a>
                            <?php else: ?>
                                <span class="btn-m3 btn-warning-m3 btn-m3-sm disabled" title="Tidak ada otoritas" style="pointer-events:none;opacity:0.6;border-radius:8px;">
                                    <span class="material-symbols-rounded align-middle">edit</span>
                                </span>
                                <span class="btn-m3 btn-danger-m3 btn-m3-sm disabled" title="Tidak ada otoritas" style="pointer-events:none;opacity:0.6;border-radius:8px;">
                                    <span class="material-symbols-rounded align-middle">delete</span>
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Pager modern jika ada -->
    <?php if (isset($pager)) : ?>
        <div class="pager-m3 mt-3 d-flex justify-content-center">
            <?= $pager->links() ?>
        </div>
    <?php endif; ?>
</div>
<!-- Material 3 styles assumed to be globally included. -->
