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
            <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_jumlahmata' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_jumlahmata') ?>">Master Jumlah Mata</a></li>
            <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_kaki' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_kaki') ?>">Master Kaki</a></li>
            <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_merk' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_merk') ?>">Master Merk</a></li>
            <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_model' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_model') ?>">Master Model</a></li>
            <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_pelengkap' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_pelengkap') ?>">Master Pelengkap</a></li>
            <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_satuan' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_satuan') ?>">Master Satuan</a></li>
            <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_ukuranbarang' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_ukuranbarang') ?>">Master Ukuran Barang</a></li>
            <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_voltase' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_voltase') ?>">Master Voltase</a></li>
            <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_warnabibir' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_warnabibir') ?>">Master Warna Bibir</a></li>
            <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_warnabody' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_warnabody') ?>">Master Warna Body</a></li>
            <li><a class="dropdown-item<?= service('uri')->getSegment(2) == 'otorisasi_warnasinar' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_warnasinar') ?>">Master Warna Sinar</a></li>
        </ul>
    </div>
</div>
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
        border: 0.5px solid #dee2e6;
    }

    /* Hilangkan border double di sudut */
    .table-radius th:first-child {
        border-left-width: 0.5px;
    }

    .table-radius th:last-child {
        border-right-width: 0.5px;
    }

    .table-radius tr:last-child td:first-child {
        border-left-width: 0.5px;
    }

    .table-radius tr:last-child td:last-child {
        border-right-width: 0.5px;
    }

    .table-radius tr:first-child th {
        border-top-width: 0.5px;
    }

    .table-radius tr:last-child td {
        border-bottom-width: 0.5px;
    }
</style>