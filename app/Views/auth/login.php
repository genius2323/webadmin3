<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login - Web Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="ArchitectUI HTML Bootstrap 4 Dashboard Template">
    <meta name="msapplication-tap-highlight" content="no">
    
    <!-- Memuat file CSS utama dari folder /public -->
    <link href="<?= base_url('assets/css/base.css') ?>" rel="stylesheet">
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100 bg-plum-plate bg-animation">
                <div class="d-flex h-100 justify-content-center align-items-center">
                    <div class="mx-auto app-login-box col-md-8 col-lg-6">
                        <div class="app-logo-inverse mx-auto mb-3"></div>
                        <div class="modal-dialog w-100 mx-auto">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="h5 modal-title text-center">
                                        <h4 class="mt-2">
                                            <div>Selamat Datang,</div>
                                            <span>Silakan login ke akun Anda.</span>
                                        </h4>
                                    </div>
                                    

                                    <!-- Menampilkan pesan error jika login gagal -->
                                    <?php if(session()->getFlashdata('error')): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= session()->getFlashdata('error') ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Menampilkan pesan error validasi -->
                                    <?php if(session()->getFlashdata('errors')): ?>
                                        <div class="alert alert-warning" role="alert">
                                            <ul class="mb-0">
                                            <?php foreach(session()->getFlashdata('errors') as $err): ?>
                                                <li><?= esc($err) ?></li>
                                            <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Form akan dikirim ke route /login/process -->
                                    <form method="post" action="<?= site_url('login/process') ?>">
                                        <?= csrf_field() ?>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <input name="username" id="exampleUsername" placeholder="Username" type="text" class="form-control" required value="<?= old('username') ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <input name="password" id="examplePassword" placeholder="Password" type="password" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <select name="department_id" class="form-control" required>
                                                        <option value="">Pilih Departemen</option>
                                                        <?php
                                                        $departments = model('App\\Models\\DepartmentModel')->findAll();
                                                        $oldDept = old('department_id');
                                                        foreach ($departments as $dept): ?>
                                                            <option value="<?= $dept['id'] ?>" <?= $oldDept == $dept['id'] ? 'selected' : '' ?>><?= $dept['name'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="position-relative form-check">
                                            <input name="remember" id="exampleCheck" type="checkbox" class="form-check-input">
                                            <label for="exampleCheck" class="form-check-label">Keep me logged in</label>
                                        </div>
                                    
                                </div>
                                <div class="modal-footer clearfix">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-primary btn-lg">Login to Dashboard</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="text-center text-white opacity-8 mt-3">Copyright © Your Company 2025</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= base_url('assets/scripts/main.js') ?>"></script>
</body>
</html>
