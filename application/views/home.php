<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard - SIA Mercu Buana</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/'); ?>/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/dist/'); ?>/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">


        <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
            </ul>
        </nav>



        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="<?= base_url('index.php/web/home'); ?>" class="brand-link">
                <img src="<?= base_url('assets/images/logo.png'); ?>" alt="logo" class="ml-3 img-size-32 mr-2">
                <span class="brand-text font-weight-light">SIA Mercu Buana</span>
            </a>


            <div class="sidebar">


                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="<?= base_url('index.php/web/home'); ?>" class="nav-link active">
                                <i class="nav-icon fa fa-dashboard"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="javascript:;" class="nav-link">
                                <i class="nav-icon fa fa-table"></i>
                                <p>
                                    Data Master
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url('index.php/web/data_master/mahasiswa'); ?>" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>Mahasiswa</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('index.php/web/data_master/matakuliah'); ?>" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>Mata Kuliah</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('index.php/web/data_master/nilai'); ?>" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>Nilai</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('index.php/web/rekap/nilai_mhs'); ?>" class="nav-link">
                                <i class="nav-icon fa fa-list"></i>
                                <p>Rekap Nilai Mata Kuliah</p>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>

        </aside>


        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Dashboard</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="javascript:;">SIA Mercu Buana</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?= $jml_mhs; ?></h3>
                                    <p>total mahasiswa</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-person"></i>
                                </div>
                                <a href="<?= base_url('index.php/web/data_master/mahasiswa'); ?>" class="small-box-footer">lihat data mahasiswa <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">

                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?= $jml_mk; ?></h3>
                                    <p>total mata kuliah</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cube"></i>
                                </div>
                                <a href="<?= base_url('index.php/web/data_master/matakuliah'); ?>" class="small-box-footer">lihat data mata kuliah <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">

                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?= $jml_nilai; ?></h3>
                                    <p>total data nilai</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-list"></i>
                                </div>
                                <a href="<?= base_url('index.php/web/data_master/nilai'); ?>" class="small-box-footer">lihat data nilai <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

        </div>

        <footer class="main-footer">
            Copyright &copy; <?= date('Y'); ?> Muhammad Fadhiil Rachman
            <div class="float-right d-none d-sm-inline-block">
                <b>NIM</b> 41516010040
            </div>
        </footer>

    </div>

    <script src="<?= base_url('assets/plugins/'); ?>/jquery/jquery.min.js"></script>

    <script src="<?= base_url('assets/plugins/'); ?>/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

    <script src="<?= base_url('assets/plugins/'); ?>/slimScroll/jquery.slimscroll.min.js"></script>

    <script src="<?= base_url('assets/plugins/'); ?>/fastclick/fastclick.js"></script>

    <script src="<?= base_url('assets/dist/'); ?>/js/adminlte.js"></script>

    <script src="<?= base_url('assets/dist/'); ?>/js/pages/dashboard.js"></script>
</body>

</html>