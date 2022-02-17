<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Distribusi Produk</h1>
        <small>Daftar Faktur Penjualan</small>
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

<!-- Main content -->
<div class="container-fluid p-3">

  <div class="card card-default g-tema">
    <div class="card-header">
      <div class="h3 card-title">Data Invoice Pelanggan</div>
      <div class="card-tools d-none d-sm-block">
        <a href="distribusi/tambah" class="text-primary h4 mr-2" data-toggle="tooltip" data-placement="top" title="Tambah distribusi"><i class="fa fa-plus-square"></i></a>
      </div>
    </div>
    <div class="card-body">
      <!--<img src="<?= 'https://' . $_SERVER['HTTP_HOST'] ?>/assets/img/makna2-loading.gif" alt='loading...' width='150' class="mx-auto d-block wait-preloader d-none" />-->
      <div class="table-responsive">
        <table class="table table-bordered tabled-hover" id="example1">
          <thead class="thead-dark">
            <tr>
              <th width="15">No</th>
              <th>INVOICE</th>
              <th>Nama Customer</th>
              <th>Tanggal Input</th>
              <th>Jumlah Produk</th>
              <th><i class="fa fa-cog"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach ($distribusi as $q) : ?>
              <?php $kode = $q['kode_customer'] ?>
              <tr>
                <td align="center"><?= $i++; ?></td>
                <td data-toggle="tooltip" data-placement="top" title="Jumlah Jenis Alat <?= count($this->db->get_where('tb_pesan', ['kode_customer' => $kode])->result_array()); ?>"><strong><?= $q['invoice']; ?></strong></td>
                <td><?= $q['nama_customer']; ?></td>
                <td><?= $q['tanggal']; ?></td>
                <td data-toggle="tooltip" data-placement="right" title="Jumlah Alat <?= count($this->db->get_where('tb_pesan', ['kode_customer' => $kode])->result_array()); ?>"><?= $q['jumlah_alat']; ?></td>
                <td align="center">
                  <a href="distribusi/hapusInv/<?= $kode; ?>" class="btn btn-sm btn-danger hapus"><i class="fa fa-trash-alt"></i></a>
                  <a href="distribusi/edit/<?= $kode; ?>" class="btn btn-sm bg-gradient-primary"><i class="fa fa-user-edit"></i></a>
                  <a href="distribusi/invoice/<?= $kode; ?>" target="_blank" class="btn btn-sm bg-gradient-info"><i class="fa fa-print"></i></a>
                  <a href="distribusi/excel/<?= $kode ?>" class="btn btn-sm bg-gradient-success" data-toggle="tooltip" data-placement="top" title="Print Excel <?= $kode; ?>" target="_blank"><i class="fa fa-print"></i></a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>

    </div>
    <div class="card-footer">Distribusi Produk</div>
  </div>
  <!-- /.Card -->

</div>
<!-- /.content-wrapper -->