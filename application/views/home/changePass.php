<?php if ($this->session->flashdata('gagal')) : ?>
  <div class="gagal" data-pesan="<?= $this->session->flashdata('gagal'); ?>"></div>
<?php endif ?>
<div class="container">

  <div class="row">
    <div class="col-md-4 offset-md-4">

      <div class="login-box">
        <div class="login-logo">
          <img src="<?= base_url('assets'); ?>/img/makna.png" alt="makna" class="img-fluid">
        </div>
        <!-- /.login-logo -->

        <form action="updateProfil" enctype="multipart/form-data" method="post">
          <div class="image-upload mx-auto img-thumbnail mb-2">
            <label for="upload">
              <img src="<?= base_url('assets') . '/img/' . $this->data['session']['pic']; ?>" class="image-up" alt="gambar" id="preview">
            </label>

            <input type="file" name="upload" id="upload" name="upload" aria-describeby="upload" accept="image/*" onchange="tampilkanPreview(this, 'preview')" />
          </div>
          <small class="text-danger text-center"><?= form_error('upload'); ?></small>

          <div class="text-center mb-3">
            <button type="submit" name="submit" class="btn btn-primary d-none" id="upProfil" style="width :200px">Upload</button>
          </div>
        </form>

        <form action="update" method="post">
          <div class="card">
            <div class="card-body login-card-body">
              <small class="text-danger"><?= form_error('nama'); ?></small>

              <p class="login-box-msg">Masukan password baru sesuai dengan keinginan anda, Pastikan konfirmasi password sama dengan password yang dimasukan.</p>

              <div class="input-group mb-3">
                <input type="text" class="form-control <?= form_error('nama') ? 'is-invalid' : ''; ?>" value="<?= set_value('nama'); ?>" name="nama" placeholder="Nama (Optional)">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>

              <small class="text-danger"><?= form_error('password'); ?></small>
              <div class="input-group mb-3">
                <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : ''; ?>" value="<?= set_value('password'); ?>" name="password" placeholder="Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <small class="text-danger"><?= form_error('password2'); ?></small>
              <div class="input-group mb-3">
                <input type="password" class="form-control <?= form_error('password2') ? 'is-invalid' : ''; ?>" value="<?= set_value('password2'); ?>" name="password2" placeholder="Confirm Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <button type="submit" name="submit" class="btn btn-primary btn-block">Change</button>
                </div>
                <!-- /.col -->
              </div>
            </div>
        </form>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

</div>
</div>
</div>