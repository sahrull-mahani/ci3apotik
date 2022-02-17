<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $judul; ?></title>
  <link rel="shorcut icon" href="<?= base_url('assets'); ?>/favicon.ico">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

  <!-- JQVMap -->
  <!--<link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/jqvmap/jqvmap.min.css">-->
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- jQueryUI -->
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!--flatpickr DateTimePicker-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/toastr/toastr.min.css">
  <!--summernote-->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <!-- my CSS -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/dist/css/style.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light bg-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?= base_url('home'); ?>" class="nav-link">Home</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link" id="contactChat" data-toggle="modal" data-target="#staticBackdrop">Contact<sup class="badge badge-primary" id="countPesan"><?= isset($_COOKIE['pesan']) ? $_COOKIE['pesan'] : '' ?></sup></a>
        </li>
        <li class="nav-item" style="cursor: pointer">
          <div id="timer" class="nav-link">
            <span id="days"></span>
            <span id="hours"></span>
            <span id="minutes"></span>
            <span id="seconds"></span>
            <!--Time LOGON-->
            <span id="nowTimeCount" class="nav-link d-none" data-timer="<?= date('d M Y H:i:s', $this->data['cookie'][2]) ?>"></span>
          </div>
        </li>
      </ul>

    </nav>
    <!-- /.navbar -->

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content g-tema">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Chat Group</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="messageList" class="mb-1" style="max-height: 50vh; overflow-y: auto;">

            </div>
            <hr>
            <div class="row">
              <div class="col-md">
                <div id="form-message">
                  <div class="login-card-body p-0 m-0">
                      <div class="input-group mb-3 g-tema">
                        <input type="text" id="message" class="form-control g-tema <?= $this->data['session']['id']." ".str_replace(" ", "_",$this->data['session']['nama']); ?>" placeholder="Tulis pesan..." autofocus>
                        <div class="input-group-append g-tema">
                          <div class="input-group-text">
                            <span class="fas fa-paper-plane text-primary pr-2" id="sendMessage" style="cursor: pointer"></span>
                            <div class="spinner-border text-primary spinner-border-sm pr-2 d-none" id="btn-sd-loading" role="status">
                              <span class="sr-only">Loading...</span>
                            </div>
                            <?php if ($this->data['session']['level'] == 0) : ?>
                                &#124; <span class="fas fa-trash text-danger pl-2" id="truncteChat" style="cursor: pointer"></span>
                                <div class="spinner-border text-danger spinner-border-sm pl-2 d-none" id="btn-tr-loading" role="status">
                                  <span class="sr-only">Loading...</span>
                                </div>
                            <?php endif ?>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= base_url(); ?>" class="brand-link">
        <img src="<?= base_url('assets'); ?>/img/makna2.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">PT. Makna</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?= base_url('assets') . "/img/" . $this->data['session']['pic']; ?>" class="img-circle pic" alt="User Image">
          </div>
          <div class="info">
            <a href="<?= base_url(); ?>home/changePass" class="d-block text-capitalize"><?= $this->data['session']['nama']; ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="<?= base_url('home'); ?>" class="nav-link">
                <i class="fa fa-home nav-icon"></i>
                <p>Beranda</p>
              </a>
            </li>

            <li class="nav-header">MASTER DATA</li>
            <li class="nav-item">
              <a href="<?= base_url('produk'); ?>" class="nav-link">
                <i class="fa fa-medkit nav-icon"></i>
                <p>Produk</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('customer'); ?>" class="nav-link">
                <i class="fa fa-users nav-icon"></i>
                <p>Customer</p>
              </a>
            </li>
            <li class="nav-header">DATA DISTRIBUSI</li>
            <li class="nav-item">
              <a href="<?= base_url('distribusi') ?>" class="nav-link">
                <i class="fa fa-shopping-cart nav-icon"></i>
                <p>Distribusi Produk</p>
              </a>
            </li>

            <?php if ($this->data['session']['level'] == 0) : ?>
              <li class="nav-header">Users</li>
              <li class="nav-item">
                <a href="<?= base_url('users'); ?>/tambah" class="nav-link">
                  <i class="fa fa-user-plus nav-icon"></i>
                  <p>Tambah User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('users'); ?>" class="nav-link">
                  <i class="fa fa-user-friends nav-icon"></i>
                  <p>Daftar User</p>
                </a>
              </li>
            <?php endif ?>
            
            <li class="nav-header">Tema</li>
            <div class="btn-group px-3 rounded" role="group" aria-label="Basic example">
              <span class="btn bg-gradient-dark text-warning btn-sm cursor-pointer glow-yellow" id="dark-theme" data-toggle="tooltip" data-placement="bottom" title="Dark theme"><i class="fa fa-moon"></i></span>
              <span class="btn bg-gradient-light text-warning btn-sm cursor-pointer glow-yellow d-none" id="light-theme" data-toggle="tooltip" data-placement="bottom" title="Light theme"><i class="far fa-sun"></i></span>
              <span class="btn bg-gradient-info text-warning btn-sm cursor-pointer glow-yellow" id="blue-theme" data-toggle="tooltip" data-placement="bottom" title="Blue theme"><i class="fa fa-bolt"></i></span>
            </div>

            <li class="nav-header">UTILITY</li>
            <li class="nav-item has-treeview">
            <li class="nav-item">
              <a href="<?= base_url('home'); ?>/logout" class="nav-link keluar">
                </i><i class="fas fa-sign-out-alt nav-icon"></i>
                <p>keluar</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php if ($this->session->flashdata('success')) : ?>
        <div class="pesan" data-pesan="<?= $this->session->flashdata('success'); ?>"></div>
      <?php endif ?>
      <?php if ($this->session->flashdata('warning')) : ?>
        <div class="warning" data-pesan="<?= $this->session->flashdata('warning'); ?>"></div>
      <?php endif ?>