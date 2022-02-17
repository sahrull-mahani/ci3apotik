<section class="content-header">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Data Tambah Produk</h1>
      <small>Silahkan Input Data Produk Anda</small>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Tambah Data Produk</h3>
      </div>
      <form action="<?= base_url('produk'); ?>/saveProduk" method="post">
        <img src="<?= 'https://'.$_SERVER['HTTP_HOST'] ?>/assets/img/makna2-loading.gif" alt='loading...' width='150' class="mx-auto d-block wait-preloader d-none" />
        <div class="card-body d-none g-tema">

          <div class="form-group">
            <label for="nama_alat">Nama Produk</label>
            <input type="text" class="form-control g-tema <?= form_error('nama_alat') ? 'is-invalid' : ''; ?>" id="nama_alat" name="nama_alat" style="text-transform: capitalize" placeholder="Contoh : Paracetamol" value="<?= set_value('nama_alat'); ?>">
            <div id="validationServer04Feedback" class="invalid-feedback">
              <?= form_error('nama_alat'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="kode_alat">Kode Produk</label>
            <input type="text" class="form-control g-tema <?= form_error('kode_alat') ? 'is-invalid' : ''; ?>" id="kode_alat" name="kode_alat" onkeyup="this.value = this.value.toUpperCase();" placeholder="Contoh : GUI01" value="<?= set_value('kode_alat'); ?>">
            <div id="validationServer04Feedback" class="invalid-feedback">
              <?= form_error('kode_alat'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="satuan">Satuan</label>
            <input type="text" class="form-control g-tema <?= form_error('satuan') ? 'is-invalid' : ''; ?>" id="satuan" name="satuan" style="text-transform: capitalize;" placeholder="Pcs/Box/ Dan Lainnya" value="<?= set_value('satuan'); ?>">
            <div id="validationServer04Feedback" class="invalid-feedback">
              <?= form_error('stok'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="expired" class="font-italic">Expired</label>
            <input type="text" class="form-control g-tema <?= form_error('expired') ? 'is-invalid' : ''; ?> tanggal" id="expired" autocomplete="off" name="expired" style="text-transform: capitalize;" placeholder="DD-MM-YYYY" value="<?= set_value('expired'); ?>" readonly>
            <div id="validationServer04Feedback" class="invalid-feedback">
              <?= form_error('expired'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="harga">Harga Alat</label>
            <input type="text" class="form-control g-tema <?= form_error('harga') ? 'is-invalid' : ''; ?>" id="harga" name="harga" data-a-sign="Rp. " data-a-dec="," data-a-sep="." placeholder="Rp." value="<?= set_value('harga'); ?>">
            <div id="validationServer04Feedback" class="invalid-feedback">
              <?= form_error('stok'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="stok">Stok Produk</label>
            <input type="number" class="form-control g-tema <?= form_error('stok') ? 'is-invalid' : ''; ?>" id="stok" name="stok" placeholder="Masukkan Jumlah Stok sesuai Data yang tersedia" value="<?= set_value('stok'); ?>">
            <div id="validationServer04Feedback" class="invalid-feedback">
              <?= form_error('stok'); ?>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-danger">Reset</button>
          </div>

        </div>
      </form>
    </div>
  </div>
</section>