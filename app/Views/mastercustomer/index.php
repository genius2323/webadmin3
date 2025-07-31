<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="page-header" style="display:flex;align-items:center;gap:16px;margin-left:24px;margin-bottom:18px;">
    <div class="page-header-icon" style="display:flex;align-items:center;">
        <span class="material-symbols-outlined" style="font-size:2.2rem;">person</span>
    </div>
    <div>
        <h1 class="page-header-title" style="margin:0;">Master Customer</h1>
        <p class="page-header-subtitle" style="margin:0;">Kelola seluruh data customer di sini.</p>
    </div>
</div>
<div class="content-card">
    <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; margin-bottom: 20px;">
        <form method="get" style="display: flex; gap: 6px; align-items: center;">
            <input type="text" name="keyword" class="input-m3-date" placeholder="Cari nama customer..." value="<?= esc($_GET['keyword'] ?? '') ?>" style="height:32px; font-size:0.95rem; padding:6px 10px; border-radius:8px;">
            <button type="submit" class="btn-m3 btn-m3-sm" style="height:32px; min-width:32px; padding:6px 10px; border-radius:8px;" title="Cari"><span class="material-symbols-outlined" style="font-size:18px;">search</span></button>
        </form>
        <a href="<?= site_url('mastercustomer/create') ?>" class="btn-m3 btn-m3-sm" style="height:32px; min-width:32px; padding:6px 10px; border-radius:8px; text-decoration:none;">
            <span class="material-symbols-outlined" style="vertical-align: middle; font-size:18px;">add</span>
            <span style="font-size:0.95rem;">Tambah</span>
        </a>
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
                    <th style="text-align:center;">No</th>
                    <th style="text-align:center;">Kode</th>
                    <th style="text-align:center;">Nama</th>
                    <th style="text-align:center;">Alamat</th>
                    <th style="text-align:center;">Contact Person</th>
                    <th style="text-align:center;">Kota</th>
                    <th style="text-align:center;">Provinsi</th>
                    <th style="text-align:center;">Sales</th>
                    <th style="text-align:center;">No HP</th>
                    <th style="text-align:center;">Batas Piutang</th>
                    <th style="text-align:center;">NPWP</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($customers)): ?>
                    <?php foreach ($customers as $i => $row): ?>
                        <tr>
                            <td style="text-align:center;"> <?= $i + 1 ?> </td>
                            <td><?= esc($row['kode_customer']) ?></td>
                            <td style="white-space: nowrap !important;"> <?= esc($row['nama_customer']) ?></td>
                            <td class="text-center"><?= esc($row['alamat']) ?></td>
                            <td style="white-space: nowrap !important;"><?= esc($row['contact_person']) ?></td>
                            <td class="text-center"><?= esc($row['kota']) ?></td>
                            <td class="text-center"><?= esc($row['provinsi']) ?></td>
                            <td style="white-space: nowrap !important;"><?= esc($row['sales']) ?></td>
                            <td class="text-center"><?= esc($row['no_hp']) ?></td>
                            <td style="white-space: nowrap !important;text-align:right;">Rp <?= number_format($row['batas_piutang'], 0, ',', '.') ?></td>
                            <td class="text-center"><?= esc($row['npwp_nomor']) ?></td>
                            <td style="min-width:80px;display:flex;gap:4px;justify-content:center;align-items:center;">
                                <?php if (isset($row['otoritas']) && $row['otoritas'] === 'T'): ?>
                                    <a href="<?= site_url('mastercustomer/edit/' . $row['id']) ?>" class="btn-m3 btn-m3-sm btn-m3-warning" style="height:28px; min-width:28px; padding:4px 8px; border-radius:8px; text-decoration:none; background:#FFD600; color:#333;">
                                        <span class="material-symbols-outlined" style="font-size:16px;">edit</span>
                                    </a>
                                    <a href="<?= site_url('mastercustomer/delete/' . $row['id']) ?>" class="btn-m3 btn-m3-sm btn-m3-danger" style="height:28px; min-width:28px; padding:4px 8px; border-radius:8px; text-decoration:none; background:#e53935; color:#fff;" onclick="return confirm('Yakin ingin menghapus data ini?')">
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
                <?php else: ?>
                    <tr>
                        <td colspan="12" style="text-align:center; color:var(--color-on-surface-variant);">Data tidak ditemukan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>