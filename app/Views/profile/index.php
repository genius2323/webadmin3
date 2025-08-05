<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-xl px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        Account Settings
                    </h1>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container-xl px-4 mt-4">
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="<?= site_url('profile') ?>">Profile</a>
        <a class="nav-link" href="<?= site_url('profile/security') ?>">Security</a>
    </nav>
    <hr class="mt-0 mb-4" />
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"> <?= session()->getFlashdata('success') ?> </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-xl-4">
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <img class="img-account-profile rounded-circle mb-2" src="<?= base_url($user['profile_image'] ?? 'assets/img/illustrations/profiles/profile-1.png') ?>" alt="" style="width:120px;height:120px;object-fit:cover;" />
                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                    <form method="post" enctype="multipart/form-data" action="<?= site_url('profile/update') ?>">
                        <?= csrf_field() ?>
                        <input type="file" name="profile_image" class="form-control mb-2" accept="image/*">
                        <button class="btn btn-primary btn-sm" type="submit">Upload new image</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <form method="post" action="<?= site_url('profile/update') ?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Username</label>
                            <input class="form-control" id="inputUsername" name="username" type="text" value="<?= esc($user['username'] ?? '') ?>" required />
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="inputNama">Nama</label>
                            <input class="form-control" id="inputNama" name="nama" type="text" value="<?= esc($user['nama'] ?? '') ?>" required />
                        </div>
                        <!-- Hanya tampilkan field yang ada di tabel users: username, nama, alamat, noktp, profile_image, birthday -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputAlamat">Alamat</label>
                            <input class="form-control" id="inputAlamat" name="alamat" type="text" value="<?= esc($user['alamat'] ?? '') ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="inputNoKTP">No. KTP</label>
                            <input class="form-control" id="inputNoKTP" name="noktp" type="text" value="<?= esc($user['noktp'] ?? '') ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="inputBirthday">Tanggal Lahir</label>
                            <?php
                            // Konversi yyyy-mm-dd ke yyyy-mm-dd untuk input type date
                            $birthdayVal = isset($user['birthday']) && $user['birthday'] ? date('Y-m-d', strtotime($user['birthday'])) : '';
                            ?>
                            <div class="input-group">
                                <input type="date" name="birthday" id="inputBirthday" class="form-control" value="<?= esc($birthdayVal) ?>" autocomplete="off">

                            </div>
                        </div>
                        <?php $this->section('styles'); ?>
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                        <?php $this->endSection(); ?>

                        <?php $this->section('scripts'); ?>
                        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                flatpickr('#inputBirthday', {
                                    dateFormat: 'd/m/Y',
                                    disableMobile: true,
                                    allowInput: true
                                });
                            });
                        </script>
                        <?php $this->endSection(); ?>
                        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>