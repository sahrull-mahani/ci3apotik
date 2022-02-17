<?php if ($validations) : ?>
  <div class="alert alert-danger alertTimeOut mx-3 mt-2" role="alert">
    <h4 class="alert-heading">Gagal!</h4>
    <strong><?= $validations; ?></strong>
    <hr>
    <p class="mb-0">Pesan akan menghilang dalam 5 detik.</p>
  </div>
<?php endif ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Produk</h1>
        <small>Silahkan Input Data Produk Anda</small>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<div class="preloader">
  <div class="loading">
    <img src="<?= base_url('assets'); ?>/img/makna2-loading.gif" width="80">
    <p>Harap Tunggu</p>
  </div>
</div>

<div class="container-fluid">

  <div class="card g-tema">
    <div class="card-header">
      <div class="card-title">Data Produk</div>
      
      <div class="card-tools">
        <div class="btn-group d-none d-sm-block" role="group" aria-label="Basic example">
          <a href="<?= base_url('produk'); ?>/tambahProduk" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" title="Input customer"><i class="fa fa-plus-square"></i></a>
          <a href="<?= base_url('produk'); ?>/exportXL" class="btn bg-gradient-success btn-sm" data-toggle="tooltip" data-placement="top" title="Export excel"><i class="far fa-file-excel"></i></a>
          <a href="<?= base_url('produk'); ?>/import" class="btn btn-outline-success btn-sm" data-toggle="tooltip" data-placement="top" title="Import excel"><i class="far fa-file-excel"></i></a>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center" width="10">No</th>
              <th class="text-center">Nama Produk</th>
              <th class="text-center">Kode Produk</th>
              <th class="text-center">Satuan</th>
              <th class="text-center">Expired</th>
              <th class="text-center">Harga</th>
              <th class="text-center">Stok</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach ($produk as $k) : ?>
              <tr>
                <td class="text-center"><?= $i++; ?></td>
                <td class="text-center" class="text-capitalize"><?= ucwords($k['nama_alat']); ?></td>
                <td class="text-center" class="text-uppercase"><?= strtoupper($k['kode_alat']); ?></td>
                <td class="text-center" class="text-capitalize"><?= ucwords($k['satuan']); ?></td>
                <td class="text-center" class="text-capitalize"><?= $k['expired']; ?></td>
                <td class="text-center"><?= rupiah($k['harga']); ?></td>
                <td class="text-center"><?= $k['stok']; ?></td>
                <td class="text-center">

                  <a href="#" class="btn btn-info" data-toggle="modal" data-target="#editProduk<?= $k['id']; ?>"><i class="fa fa-edit"></i></a>

                  <div class="modal fade" id="editProduk<?= $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Edit Data Customer</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <hr>
                          <form action="<?= base_url('produk/'); ?>updateProduk/<?= $k['id']; ?>" method="post">
                            <div class="form-group">
                              <label>Nama Produk</label>
                              <input type="text" value="<?= $k['nama_alat'] ? $k['nama_alat'] : set_value('nama_alat'); ?>" style="text-transform: capitalize;" name="nama_alat" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Kode Alat</label>
                              <input type="text" value="<?= $k['kode_alat'] ? $k['kode_alat'] : set_value('kode_alat'); ?>" style="text-transform: capitalize;" name="kode_alat" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Satuan</label>
                              <input type="text" value="<?= $k['satuan'] ? $k['satuan'] : set_value('satuan'); ?>" style="text-transform: capitalize;" name="satuan" class="form-control">
                            </div>
                            <div class="form-group">
                              <label class="font-italic">Expired</label>
                              <input type="text" value="<?= $k['expired'] ? $k['expired'] : set_value('expired'); ?>" data-expired="expired" autocomplete="off" name="expired" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Harga</label>
                              <input type="text" value="<?= $k['harga'] ? $k['harga'] : set_value('harga'); ?>" id="harga" name="harga" data-a-sign="Rp. " data-a-dec="," data-a-sep="." placeholder="Rp." class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Jumlah</label>
                              <input type="text" value="<?= $k['stok'] ? $k['stok'] : set_value('stok'); ?>" name="stok" class="form-control">
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" name="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </div>
                        </form>
                      </div>
                      <!-- Ending Modal Edit -->
                    </div>
                    <!-- Ending Modal Content -->
                  </div>
                  <!-- Ending Modal -->
      </div>
      <!-- Ending Tombol Edit -->

      <a class="btn btn-danger hapus" href="<?= base_url('produk'); ?>/deleteProduk/<?= $k['id']; ?>"><i class="fa fa-trash"></i></a>
      </td>
      </tr>
    <?php endforeach ?>
    </tbody>
    </tfoot>
    </table>
    </div>
  </div>
  <!-- /.card-body -->

</div>

</div>