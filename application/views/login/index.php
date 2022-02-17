<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MAKNA Login</title>
  <link rel="shorcut icon" href="<?= base_url(); ?>assets/favicon.ico">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Toastr -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/adminlte.min.css">
  <!-- my CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/style.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">

  <!-- loading -->
  <div class="preloader">
    <div class="loading">
      <img src="<?= base_url(); ?>assets/img/makna2-loading.gif" width="80">
      <p>Harap Tunggu</p>
    </div>
  </div>
  <!-- /.loading -->

  <!-- message -->
  <?php if ($this->session->flashdata('gagal')) : ?>
    <div class="gagal" data-pesan="<?= $this->session->flashdata('gagal'); ?>"></div>
  <?php endif ?>

  <div class="login-box">
    <div class="login-logo">
      <img src="<?= base_url(); ?>assets/img/makna.png" alt="makna" class="img-fluid" style="padding: 10px;">
    </div>
    <!-- /.login-logo -->
    <div class="card" style="margin-right: 20px; margin-top:20px; margin-bottom: 150px;">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Masukkan Email Dan Password</p>
        <form action="<?= base_url('login'); ?>/process" method="post">
          <div class="input-group">
            <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : ''; ?>" name="email" placeholder="Email" value="<?= set_value('email'); ?>" autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <small class="text-danger mb-3"><?= form_error('email'); ?></small>
          <div class="input-group mt-3">
            <input type="password" class="form-control ShowPass <?= form_error('password') ? 'is-invalid' : ''; ?>" name=" password" placeholder="Password" value="<?= set_value('password'); ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <small class="text-danger mb-3"><?= form_error('password') ?></small>
          <div class="row">
            <div class="col-12">
              <div class="icheck-primary">
                <input type="checkbox" id="showPass" name="show">
                <label for="showPass">Lihat Password</label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-12 mt-3">
              <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url(); ?>assets/dist/js/adminlte.min.js"></script>
  <!-- Toastr -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="<?= base_url(); ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.8/push.min.js"></script>

  <script src="<?= base_url(); ?>assets/dist/js/scriptLogin.js"></script>

</body>

</html>