<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Security - Web Admin</title>
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
</head>

<body class="nav-fixed">
    <div id="layoutSidenav_content">
        <main>
            <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
                <div class="container-xl px-4">
                    <div class="page-header-content">
                        <div class="row align-items-center justify-content-between pt-3">
                            <div class="col-auto mb-3">
                                <?php $this->extend('layout/template'); ?>

                                <?php $this->section('content'); ?>
                                <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
                                    <div class="container-xl px-4">
                                        <div class="page-header-content">
                                            <div class="row align-items-center justify-content-between pt-3">
                                                <div class="col-auto mb-3">
                                                    <h1 class="page-header-title">
                                                        <div class="page-header-icon"><i data-feather="lock"></i></div>
                                                        Account Settings - Security
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </header>
                                <div class="container-xl px-4 mt-4">
                                    <nav class="nav nav-borders">
                                        <a class="nav-link" href="<?= site_url('profile') ?>">Profile</a>
                                        <a class="nav-link active" href="<?= site_url('profile/security') ?>">Security</a>
                                    </nav>
                                    <hr class="mt-0 mb-4" />
                                    <?php if (session()->getFlashdata('success')): ?>
                                        <div class="alert alert-success"> <?= session()->getFlashdata('success') ?> </div>
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="card mb-4">
                                                <div class="card-header">Change Password</div>
                                                <div class="card-body">
                                                    <form method="post" action="<?= site_url('profile/updateSecurity') ?>">
                                                        <?= csrf_field() ?>
                                                        <div class="mb-3">
                                                            <label class="small mb-1" for="inputOldPassword">Password Lama</label>
                                                            <input class="form-control" id="inputOldPassword" name="old_password" type="password" required />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="small mb-1" for="inputPassword">Password Baru</label>
                                                            <input class="form-control" id="inputPassword" name="password" type="password" required />
                                                        </div>
                                                        <button class="btn btn-primary" type="submit">Update Password</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $this->endSection(); ?>