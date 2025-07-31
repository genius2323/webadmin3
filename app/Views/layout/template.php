<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Web Admin') ?></title>
    <!-- SBAdmin CSS -->
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon.png') ?>" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
</head>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
        <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="<?= site_url('/') ?>">Web Admin</a>
        <form class="form-inline me-auto d-none d-lg-block me-3">
            <div class="input-group input-group-joined input-group-solid">
                <input class="form-control pe-0" type="search" placeholder="Search" aria-label="Search" />
                <div class="input-group-text"><i data-feather="search"></i></div>
            </div>
        </form>
        <ul class="navbar-nav align-items-center ms-auto">
            <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="<?= base_url('assets/img/illustrations/profiles/profile-1.png') ?>" /></a>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="<?= base_url('assets/img/illustrations/profiles/profile-1.png') ?>" />
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name"><?= esc(session()->get('user_nama')) ?></div>
                            <div class="dropdown-user-details-email">user@email.com</div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= site_url('profile') ?>">
                        <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                        Account
                    </a>
                    <a class="dropdown-item" href="<?= site_url('logout') ?>">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sidenav shadow-right sidenav-light">
                <div class="sidenav-menu">
                    <div class="nav accordion" id="accordionSidenav">
                        <?php
                        $departmentId = session()->get('department_id');
                        $uri = service('uri');
                        ?>
                        <?php if ($departmentId == 1): // POS 
                        ?>
                            <div class="sidenav-menu-heading">POS Menu</div>
                            <a class="nav-link<?= $uri->getSegment(1) == '' ? ' active' : '' ?>" href="<?= site_url('/') ?>">
                                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                                Dashboard POS
                            </a>
                            <a class="nav-link<?= $uri->getSegment(1) == 'pos' && $uri->getSegment(2) == 'transaksi' ? ' active' : '' ?>" href="<?= site_url('pos/transaksi') ?>">
                                <div class="nav-link-icon"><i data-feather="dollar-sign"></i></div>
                                Transaksi
                            </a>
                            <a class="nav-link collapsed<?= in_array($uri->getSegment(1), ['penjualan', 'datapenjualan']) ? ' active' : '' ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePenjualan" aria-expanded="false" aria-controls="collapsePenjualan">
                                <div class="nav-link-icon"><i data-feather="shopping-cart"></i></div>
                                Penjualan
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse<?= in_array($uri->getSegment(1), ['penjualan', 'datapenjualan']) ? ' show' : '' ?>" id="collapsePenjualan" data-bs-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav">
                                    <a class="nav-link<?= $uri->getSegment(1) == 'penjualan' ? ' active' : '' ?>" href="<?= site_url('penjualan') ?>">Input Penjualan</a>
                                    <a class="nav-link<?= $uri->getSegment(1) == 'datapenjualan' ? ' active' : '' ?>" href="<?= site_url('datapenjualan') ?>">Data Penjualan</a>
                                </nav>
                            </div>
                            <a class="nav-link<?= $uri->getSegment(1) == 'batas-tanggal' ? ' active' : '' ?>" href="<?= site_url('batas-tanggal') ?>">
                                <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                                Batas Tanggal
                            </a>
                        <?php elseif ($departmentId == 2): // Backoffice 
                        ?>
                            <div class="sidenav-menu-heading">Backoffice Menu</div>
                            <a class="nav-link<?= $uri->getSegment(1) == '' ? ' active' : '' ?>" href="<?= site_url('/') ?>">
                                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link<?= $uri->getSegment(1) == 'backoffice' && $uri->getSegment(2) == 'laporan' ? ' active' : '' ?>" href="<?= site_url('backoffice/laporan') ?>">
                                <div class="nav-link-icon"><i data-feather="file-text"></i></div>
                                Laporan
                            </a>
                        <?php elseif ($departmentId == 3): // General 
                        ?>
                            <div class="sidenav-menu-heading">General Menu</div>
                            <a class="nav-link<?= $uri->getSegment(1) == '' ? ' active' : '' ?>" href="<?= site_url('/') ?>">
                                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link<?= $uri->getSegment(1) == 'datapenjualan' ? ' active' : '' ?>" href="<?= site_url('datapenjualan') ?>">
                                <div class="nav-link-icon"><i data-feather="file-text"></i></div>
                                Data Penjualan
                            </a>
                            <div class="sidenav-menu-heading">Master</div>
                            <a class="nav-link<?= $uri->getSegment(1) == 'mastersales' ? ' active' : '' ?>" href="<?= base_url('mastersales') ?>">
                                <div class="nav-link-icon"><i data-feather="users"></i></div>
                                Sales / Pegawai
                            </a>
                            <a class="nav-link<?= $uri->getSegment(1) == 'mastercustomer' ? ' active' : '' ?>" href="<?= base_url('mastercustomer') ?>">
                                <div class="nav-link-icon"><i data-feather="users"></i></div>
                                Customer
                            </a>
                            <a class="nav-link<?= $uri->getSegment(1) == 'user' ? ' active' : '' ?>" href="<?= site_url('user') ?>">
                                <div class="nav-link-icon"><i data-feather="user-check"></i></div>
                                Manajemen User
                            </a>
                            <a class="nav-link<?= $uri->getSegment(1) == 'masterbarang' ? ' active' : '' ?>" href="<?= site_url('masterbarang') ?>">
                                <div class="nav-link-icon"><i data-feather="package"></i></div>
                                Master Barang
                            </a>
                            <?php
                            $klasifikasi_segments = [
                                'masterkategori',
                                'masterdaya',
                                'masterdimensi',
                                'masterfiting',
                                'mastergondola',
                                'masterjenis',
                                'masterjumlahmata',
                                'masterkaki',
                                'mastermerk',
                                'mastermodel',
                                'masterpelengkap',
                                'mastersatuan',
                                'masterukuranbarang',
                                'mastervoltase',
                                'masterwarnabibir',
                                'masterwarnabody',
                                'masterwarnasinar'
                            ];
                            $klasifikasiActive = in_array($uri->getSegment(1), $klasifikasi_segments);
                            ?>
                            <a class="nav-link collapsed<?= $klasifikasiActive ? ' active' : '' ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseKlasifikasi" aria-expanded="false" aria-controls="collapseKlasifikasi">
                                <div class="nav-link-icon"><i data-feather="layers"></i></div>
                                Master Klasifikasi
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse<?= $klasifikasiActive ? ' show' : '' ?>" id="collapseKlasifikasi" data-bs-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav">
                                    <?php foreach ($klasifikasi_segments as $segment): ?>
                                        <?php
                                        $label = str_replace('master', 'Master ', $segment);
                                        $label = ucwords(str_replace('_', ' ', $label));
                                        ?>
                                        <a class="nav-link<?= $uri->getSegment(1) == $segment ? ' active' : '' ?>" href="<?= site_url($segment) ?>"> <?= $label ?> </a>
                                    <?php endforeach; ?>
                                </nav>
                            </div>
                            <div class="sidenav-menu-heading">Fasilitas</div>
                            <a class="nav-link collapsed<?= in_array($uri->getSegment(1), ['otorisasi_klasifikasi']) ? ' active' : '' ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseOtoritas" aria-expanded="false" aria-controls="collapseOtoritas">
                                <div class="nav-link-icon"><i data-feather="shield"></i></div>
                                Otoritas
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse<?= in_array($uri->getSegment(1), ['otorisasi_klasifikasi']) ? ' show' : '' ?>" id="collapseOtoritas" data-bs-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav">
                                    <a class="nav-link<?= $uri->getSegment(1) == 'otorisasi_klasifikasi' ? ' active' : '' ?>" href="<?= site_url('otorisasi_klasifikasi/otorisasi_kategori') ?>">Otorisasi Klasifikasi</a>
                                </nav>
                            </div>
                            <a class="nav-link<?= $uri->getSegment(1) == 'batas-tanggal' ? ' active' : '' ?>" href="<?= site_url('batas-tanggal') ?>">
                                <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                                Batas Tanggal
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="sidenav-footer">
                    <div class="sidenav-footer-content">
                        <div class="sidenav-footer-subtitle">Logged in as:</div>
                        <div class="sidenav-footer-title"><?= esc(session()->get('user_nama')) ?></div>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <?= $this->renderSection('content') ?>
            </main>
            <footer class="footer-admin mt-auto footer-light">
                <div class="container-xl px-4">
                    <div class="row">
                        <div class="col-md-6 small">&copy; <?= date('Y') ?> Web Admin. All rights reserved.</div>
                        <div class="col-md-6 text-md-end small">
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/scripts.js') ?>"></script>
    <script>
        if (window.feather) {
            feather.replace();
        }
    </script>
</body>

</html>