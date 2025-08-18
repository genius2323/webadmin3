<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - Web Admin</title>
    <!-- SBAdmin style (load from public/assets) -->
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container-xl px-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <!-- Basic login form-->
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header justify-content-center">
                                    <h3 class="fw-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Menampilkan pesan error jika login gagal -->
                                    <?php if (session()->getFlashdata('error')): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= session()->getFlashdata('error') ?>
                                        </div>
                                    <?php endif; ?>
                                    <!-- Menampilkan pesan error validasi -->
                                    <?php if (session()->getFlashdata('errors')): ?>
                                        <div class="alert alert-warning" role="alert">
                                            <ul class="mb-0">
                                                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                                    <li><?= esc($err) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    <!-- Login form-->
                                    <form method="post" action="<?= site_url('login/process') ?>">
                                        <?= csrf_field() ?>
                                        <!-- Form Group (username/email address)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputUsername">Username</label>
                                            <input class="form-control" id="inputUsername" name="username" type="text" placeholder="Enter username" required value="<?= old('username') ?>" />
                                        </div>
                                        <!-- Form Group (password)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputPassword">Password</label>
                                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Enter password" required />
                                        </div>
                                        <!-- Form Group (department select)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputDepartment">Departemen</label>
                                            <select name="department_id" id="inputDepartment" class="form-control" required>
                                                <option value="">Pilih Departemen</option>
                                                <?php
                                                $departments = model('App\\Models\\DepartmentModel')->findAll();
                                                $oldDept = old('department_id');
                                                foreach ($departments as $dept): ?>
                                                    <option value="<?= $dept['id'] ?>" <?= $oldDept == $dept['id'] ? 'selected' : '' ?>><?= $dept['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <!-- Form Group (remember password checkbox)-->
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" id="rememberPasswordCheck" name="remember" type="checkbox" />
                                                <label class="form-check-label" for="rememberPasswordCheck">Keep me logged in</label>
                                            </div>
                                        </div>
                                        <!-- Form Group (login box)-->
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="#">Forgot Password?</a>
                                            <button type="submit" class="btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small"><a href="#">Need an account? Sign up!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="footer-admin mt-auto footer-dark">
                <div class="container-xl px-4">
                    <div class="row">
                        <div class="col-md-6 small">Copyright &copy; Your Company 2025</div>
                        <div class="col-md-6 text-md-end small">
                            <a href="#!">Privacy Policy</a>
                            &middot;
                            <a href="#!">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/scripts.js') ?>"></script>
</body>

<!-- Menampilkan pesan error jika login gagal -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Menampilkan pesan error validasi -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-warning" role="alert">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                <li><?= esc($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<script type="text/javascript" src="<?= base_url('assets/scripts/main.js') ?>"></script>

</html>