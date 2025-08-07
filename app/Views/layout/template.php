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
                <?php
                $user = session()->get('user');
                $profileImg = isset($user['profile_image']) && $user['profile_image'] ? base_url($user['profile_image']) : base_url('assets/img/illustrations/profiles/profile-1.png');
                $userNama = isset($user['nama']) ? $user['nama'] : (session()->get('user_nama') ?? '');
                $userEmail = isset($user['username']) ? $user['username'] : 'user@email.com';
                ?>
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="<?= $profileImg ?>" style="object-fit:cover;width:40px;height:40px;border-radius:50%;" /></a>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="<?= $profileImg ?>" style="object-fit:cover;width:48px;height:48px;border-radius:50%;" />
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name"><?= esc($userNama) ?></div>
                            <div class="dropdown-user-details-email"><?= esc($userEmail) ?></div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= site_url('profile') ?>">
                        <div class="dropdown-item-icon"><i data-feather="user"></i></div>
                        Profile
                    </a>
                    <a class="dropdown-item" href="<?= site_url('profile/security') ?>">
                        <div class="dropdown-item-icon"><i data-feather="lock"></i></div>
                        Security
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= site_url('logout') ?>">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
        <div class="d-flex justify-content-end mb-2" style="padding: 10px 20px 0 0;">
            <button id="darkModeToggle" class="btn btn-outline-secondary btn-sm">
                <span id="darkModeIcon">🌙</span>
            </button>
        </div>
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
                                    <a class="nav-link<?= $uri->getSegment(1) == 'otorisasi' && $uri->getSegment(2) == 'otorisasi_masterbarang' ? ' active' : '' ?>" href="<?= site_url('otorisasi/otorisasi_masterbarang') ?>">Otorisasi Master Barang</a>
                                    <a class="nav-link<?= $uri->getSegment(1) == 'otorisasi' && $uri->getSegment(2) == 'otorisasi_user' ? ' active' : '' ?>" href="<?= site_url('otorisasi/otorisasi_user') ?>">Otorisasi User</a>
                                    <a class="nav-link<?= $uri->getSegment(1) == 'otorisasi' && $uri->getSegment(2) == 'otorisasi_customer' ? ' active' : '' ?>" href="<?= site_url('otorisasi/otorisasi_customer') ?>">Otorisasi Customer</a>
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
        // Dark mode logic

        function setDarkMode(active) {
            if (active) {
                document.body.classList.add('dark');
                localStorage.setItem('darkMode', '1');
                var icon = document.getElementById('darkModeIcon');
                if (icon) icon.textContent = '☀️';

            } else {
                document.body.classList.remove('dark');
                localStorage.setItem('darkMode', '0');
                var icon = document.getElementById('darkModeIcon');
                if (icon) icon.textContent = '🌙';

            }
        }

        // On page load
        (function() {
            var dark = localStorage.getItem('darkMode') === '1';
            setDarkMode(dark);
            var btn = document.getElementById('darkModeToggle');
            if (btn) {
                btn.onclick = function() {
                    setDarkMode(!document.body.classList.contains('dark'));
                };
            }
        })();
    </script>
    <style>
        body.dark {
            background: #23272b !important;
        }

        body.dark main,
        body.dark .container-fluid,
        body.dark .card-body,
        body.dark .card {
            background: #23272b !important;
            color: #e0e0e0 !important;
        }

        body.dark .card-body {
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
        }

        body.dark .navbar,
        body.dark .topnav,
        body.dark .sidenav,
        body.dark .footer-admin {
            background: #202225 !important;
            color: #e0e0e0 !important;
            border-color: #23272b !important;
        }

        body.dark .table-radius th,
        body.dark .table-radius td {
            background: #23272b !important;
            color: #e0e0e0 !important;
            border-color: #333 !important;
        }

        body.dark .table-light th,
        body.dark .table-light {
            background: #23272b !important;
            color: #e0e0e0 !important;
        }

        body.dark .btn,
        body.dark .btn-outline-secondary {
            background: #23272b;
            color: #e0e0e0;
            border-color: #444;
        }

        body.dark .btn-primary,
        body.dark .btn-success,
        body.dark .btn-danger,
        body.dark .btn-warning {
            color: #fff !important;
            border: none;
        }

        body.dark .btn-primary {
            background: #4285F4 !important;
        }

        body.dark .btn-success {
            background: #34c759 !important;
        }

        body.dark .btn-danger {
            background: #e74c3c !important;
        }

        body.dark .btn-warning {
            background: #fbbc05 !important;
            color: #23272b !important;
        }

        body.dark .btn:hover,
        body.dark .btn-outline-secondary:hover {
            background: #333;
            color: #fff;
        }

        body.dark .form-control,
        body.dark .form-select {
            background: #23272b;
            color: #e0e0e0;
            border-color: #444;
        }

        body.dark .form-control:focus,
        body.dark .form-select:focus {
            background: #23272b;
            color: #fff;
            border-color: #4285F4;
            box-shadow: 0 0 0 2px #4285F488;
        }

        body.dark .alert-success {
            background: #223322;
            color: #b6fcb6;
            border-color: #2e4d2e;
        }

        body.dark .alert-danger {
            background: #332222;
            color: #fcb6b6;
            border-color: #4d2e2e;
        }

        body.dark .badge.bg-success {
            background: #2e4d2e !important;
            color: #b6fcb6 !important;
        }

        body.dark .badge.bg-secondary {
            background: #444 !important;
            color: #ccc !important;
        }

        body.dark .dropdown-menu {
            background: #23272b !important;
            color: #e0e0e0 !important;
            border-color: #333 !important;
        }

        body.dark .dropdown-item {
            color: #e0e0e0 !important;
        }

        body.dark .dropdown-item:hover,
        body.dark .dropdown-item.active {
            background: #333 !important;
            color: #fff !important;
        }

        body.dark .pagination-modern {
            background: #23272b !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        }

        body.dark .pagination-modern a,
        body.dark .pagination-modern span {
            color: #e0e0e0 !important;
        }

        body.dark .pagination-modern .active span,
        body.dark .pagination-modern a:hover {
            background: #4285F4 !important;
            color: #fff !important;
        }

        body.dark .pagination-modern .disabled span {
            color: #888 !important;
            background: #23272b !important;
        }

        body.dark hr {
            border-color: #fff !important;
        }

        body.dark .nav-link,
        body.dark .sidenav-menu-heading {
            color: #e0e0e0 !important;
        }

        body.dark .nav-link.active {
            background: #333 !important;
            color: #4285F4 !important;
        }

        body.dark .sidenav {
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.18);
        }

        body.dark .footer-admin {
            background: #23272b !important;
            color: #b0b8c1 !important;
            border-top: 1px solid #23272b !important;
        }

        /* Custom scrollbar for dark mode */
        body.dark ::-webkit-scrollbar {
            width: 10px;
            background: #23272b;
        }

        body.dark ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 8px;
        }

        body.dark .container-fluid,
        body.dark .card-body,
        body.dark .card {
            background: #23272b !important;
            color: #e0e0e0 !important;
        }

        body.dark .navbar-brand,
        body.dark .navbar-brand:visited {
            color: #fff !important;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        body.dark .navbar-brand:hover {
            color: #4285F4 !important;
        }

        /* Untuk card info, alert, dsb yang warnanya terlalu terang di dark mode */
        body.dark .alert-info,
        body.dark .bg-info,
        body.dark .card-info {
            background: #2d3a4a !important;
            color: #b6e0fe !important;
            border-color: #285680 !important;
        }

        body.dark .btn-info {
            background: #4285F4 !important;
            color: #fff !important;
        }

        /* Perbaiki input, select, dsb di dalam .container-fluid */
        body.dark .container-fluid .form-control,
        body.dark .container-fluid .form-select {
            background: #23272b !important;
            color: #e0e0e0 !important;
            border-color: #444 !important;
        }

        body.dark h1,
        body.dark h2,
        body.dark h3,
        body.dark h4,
        body.dark h5,
        body.dark h6,
        body.dark .page-header-title {
            color: #fff !important;
        }

        body.dark .page-header-title svg,
        body.dark .page-header-title i,
        body.dark h1 svg,
        body.dark h2 svg,
        body.dark h3 svg,
        body.dark h4 svg,
        body.dark h5 svg,
        body.dark h6 svg {
            color: #fff !important;
            fill: #fff !important;
        }

        body.dark #sidebarToggle svg,
        body.dark .btn-icon svg,
        body.dark .btn-transparent-dark svg {
            color: #fff !important;
            stroke: #fff !important;
            fill: none !important;
        }

        body.dark main {
            background: #23272b !important;
            color: #e0e0e0 !important;
        }

        body.dark .dropdown-user-details-name,
        body.dark .dropdown-user-details-email {
            color: #fff !important;
        }
    </style>
    <script>
        // Dark mode logic

        function setDarkMode(active) {
            if (active) {
                document.body.classList.add('dark');
                localStorage.setItem('darkMode', '1');
                var icon = document.getElementById('darkModeIcon');
                if (icon) icon.textContent = '☀️';

            } else {
                document.body.classList.remove('dark');
                localStorage.setItem('darkMode', '0');
                var icon = document.getElementById('darkModeIcon');
                if (icon) icon.textContent = '🌙';

            }
        }

        // On page load
        (function() {
            var dark = localStorage.getItem('darkMode') === '1';
            setDarkMode(dark);
            var btn = document.getElementById('darkModeToggle');
            if (btn) {
                btn.onclick = function() {
                    setDarkMode(!document.body.classList.contains('dark'));
                };
            }
        })();
        if (window.feather) {
            feather.replace({
                color: document.body.classList.contains('dark') ? '#fff' : undefined,
                stroke: document.body.classList.contains('dark') ? '#fff' : undefined
            });
        }
    </script>
</body>

</html>