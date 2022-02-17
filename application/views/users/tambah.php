<div class="register-box container">
  <div class="register-logo">
    <img src="<?= base_url('assets'); ?>/img/makna.png" alt="makna" class="img-fluid">
  </div>

  <div class="card">
    <img src="<?= 'https://' . $_SERVER['HTTP_HOST'] ?>/assets/img/makna2-loading.gif" alt='loading...' width='150' class="mx-auto d-block wait-preloader d-none" />
    <div class="card-body register-card-body d-none g-tema">
      <p class="login-box-msg">Register a new membership</p>

      <form action="tambahUser" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control g-tema <?= form_error('nama') ? 'is-invalid' : ''; ?>" name="nama" value="<?= set_value('nama'); ?>" placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          <div id="validationServer04Feedback" class="invalid-feedback">
            <?= form_error('nama'); ?>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control g-tema <?= form_error('email') ? 'is-invalid' : ''; ?>" value="<?= set_value('email'); ?>" name="email" placeholder="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          <div id="validationServer04Feedback" class="invalid-feedback">
            <?= form_error('email'); ?>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control g-tema ShowPass <?= form_error('password') ? 'is-invalid' : ''; ?>" value="<?= set_value('password'); ?>" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <div id="validationServer04Feedback" class="invalid-feedback">
            <?= form_error('password'); ?>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control g-tema ShowPass <?= form_error('password2') ? 'is-invalid' : ''; ?>" value="<?= set_value('password2'); ?>" name="password2" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <div id="validationServer04Feedback" class="invalid-feedback">
            <?= form_error('password2'); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="showPass">
              <label for="showPass">
                Lihat Password
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>

          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->