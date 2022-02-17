<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Tambah Data Customer</h1>
        <small>Silahkan Input Data Customer</small>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Tambah Data Customer</h3>
      </div>
      <form action="simpan" method="post" enctype="multipart/form-data">
        <img src="<?= 'https://' . $_SERVER['HTTP_HOST'] ?>/assets/img/makna2-loading.gif" alt='loading...' width='150' class="mx-auto d-block wait-preloader d-none" />
        <div class="card-body d-none g-tema">

          <div class="form-group">
            <label for="#">Kode Customer</label>
            <input type="text" class="form-control g-tema <?= (form_error('kode_customer')) ? 'is-invalid' : ''; ?>" id="kode_customer" onkeyup="this.value = this.value.toUpperCase();" name="kode_customer" placeholder="Kode Customer : CUS" value="<?= set_value('kode_customer'); ?>">
            <div class="invalid-feedback">
              <?= form_error('kode_customer'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="#">Nama Customer</label>
            <input type="text" class="form-control g-tema <?= (form_error('nama_customer')) ? 'is-invalid' : ''; ?>" id="nama_customer" name="nama_customer" placeholder="Contoh : PT. Berobat Dimana" value="<?= set_value('nama_customer'); ?>">
            <div class=" invalid-feedback">
              <?= form_error('nama_customer'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="#">Alamat Customer</label>
            <input type="text" class="form-control g-tema <?= (form_error('alamat')) ? 'is-invalid' : ''; ?>" id="alamat" name="alamat" placeholder="Contoh : Jlan jalanin aja dulu" value="<?= set_value('alamat'); ?>">
            <div class="invalid-feedback">
              <?= form_error('alamat'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="#">Telpon Customer</label>
            <input type="text" class="form-control g-tema <?= (form_error('telp')) ? 'is-invalid' : ''; ?>" id="telp" name="telp" placeholder="+62" value="<?= set_value('telp'); ?>">
            <div class="invalid-feedback">
              <?= form_error('telp'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="#">Faks Customer</label>
            <input type="text" class="form-control g-tema <?= (form_error('faks')) ? 'is-invalid' : ''; ?>" id="faks" name="faks" placeholder="(+62)" value="<?= set_value('faks'); ?>">
            <div class="invalid-feedback">
              <?= form_error('faks'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="#">Email Customer</label>
            <input type="text" class="form-control g-tema <?= (form_error('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Contoh : iniemail@gmail.com" value="<?= set_value('email'); ?>">
            <div class="invalid-feedback">
              <?= form_error('email'); ?>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-danger">Reset</button>
          </div>

        </div>
</section>