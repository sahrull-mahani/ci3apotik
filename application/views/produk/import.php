<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Import Data Produk</h1>
        <small>Silahkan Input Data Produk Anda Dengan File Excel</small>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<div class="container-fluid">
  <div class="card g-tema">
    <div class="card-header">
      <h5 class="card-title">Import Excel Produk</h5>
    </div>
    <div class="card-body">
      <form action="<?= base_url('produk/'); ?>importXL" method="post" enctype="multipart/form-data">
        <div class="input-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input <?= form_error('importexcel') ? 'is-invalid' : ''; ?>" accept=".xlsx,.xls,.csv" name="importexcel" id="inputGroupFile02">
            <label class="custom-file-label g-tema" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
          </div>
          <div class="input-group-append">
            <button class="btn btn-outline-success" type="submit">Import Data</button>
          </div>
        </div>
      </form>

      <div class="btn-group mt-3" role="group" aria-label="Basic example">
        <a href="<?= base_url('produk'); ?>" class="btn btn-outline-success btn-sm">&laquo; Kembali</a>
        <a href="templateXL" class="btn btn-success btn-sm">Download Template</a>
      </div>
    </div>
    <div class="card-footer">
      <?php if ($this->session->flashdata('gagal')) : ?>
        <div class="alert alert-danger alertTimeOut" role="alert">
          <h4 class="alert-heading">Gagal!</h4>
          <p><?= $this->session->flashdata('gagal'); ?></p>
          <hr>
          <p class="mb-0">Pesan akan menghilang dalam 5 detik.</p>
        </div>
      <?php endif ?>
      <?php if ($validations) : ?>
        <div class="alert alert-danger alertTimeOut" role="alert">
          <h4 class="alert-heading">Gagal!</h4>
          <strong><?= $validations; ?></strong>
          <hr>
          <p class="mb-0">Pesan akan menghilang dalam 5 detik.</p>
        </div>
      <?php endif ?>
    </div>
  </div>
</div>