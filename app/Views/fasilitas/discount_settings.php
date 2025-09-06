<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container mt-4">
    <h2 class="mb-3">Setting Discount Penjualan</h2>
    <a href="<?= site_url('discountsettings/create') ?>" class="btn btn-success mb-3">Tambah Setting Discount</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Jenis Discount</th>
                <th>Value</th>
                <th>Customer Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($settings as $row): ?>
                <tr>
                    <td><?= esc($row['discount_type']) ?></td>
                    <td>
                        <?php if ($row['discount_type'] == 'nominal'): ?>
                            Rp <?= number_format($row['value_nominal']) ?>
                        <?php elseif ($row['discount_type'] == 'persen'): ?>
                            <?= $row['value_percent'] ?> %
                        <?php elseif ($row['discount_type'] == 'bertingkat'): ?>
                            <?= esc($row['tier_json']) ?>
                        <?php elseif ($row['discount_type'] == 'customer'): ?>
                            <?= esc($row['customer_type']) ?>: <?= $row['value_percent'] ?> % / Rp <?= number_format($row['value_nominal']) ?>
                        <?php elseif ($row['discount_type'] == 'nota'): ?>
                            <?= $row['nota_percent'] ?> % / Rp <?= number_format($row['nota_nominal']) ?>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($row['customer_type']) ?></td>
                    <td>
                        <?php if ($row['active']): ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= site_url('discountsettings/edit/' . $row['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="<?= site_url('discountsettings/delete/' . $row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus setting ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection(); ?>