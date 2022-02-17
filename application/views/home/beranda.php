<div class="preloader">
  <div class="loading">
    <img src="<?= base_url('assets'); ?>/img/makna2-loading.gif" width="80">
    <p>Harap Tunggu</p>
  </div>
</div>

<div class="container-fluid mt-3">

  <div class="row">
    <div class="col-md">

      <!-- small card -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3 id="info-dal"><span id="totDis"><?= count($invoice) ?></span></h3>

          <p>Distribusi Produk</p>
        </div>
        <div class="icon">
          <i class="fas fa-shopping-cart"></i>
        </div>
        <span style="cursor: pointer;" onclick='document.location.href="<?= base_url() ?>/distribusi"' class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
      </div>

    </div>

    <div class="col-md">

      <!-- small card -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3 id="info-al"><span id="totPro"><?= count($produk) ?></span></h3>

          <p>Jumlah Produk</p>
        </div>
        <div class="icon">
          <i class="fas fa-medkit"></i>
        </div>
        <span style="cursor: pointer;" onclick='document.location.href="<?= base_url() ?>/produk"' class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
      </div>

    </div>

    <div class="col-md">

      <!-- small card -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3 id="info-cs"><span id="totCus"><?= count($customer) ?></span></h3>

          <p>Jumlah Customers</p>
        </div>
        <div class="icon">
          <i class="fas fa-users"></i>
        </div>
        <span style="cursor: pointer;" onclick='document.location.href="<?= base_url() ?>/customer"' class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
      </div>

    </div>
  </div>

  <div class="row">
    <div class="col-md">

      <!-- PRODUCT LIST -->
      <div class="card card-outline card-info g-tema">
        <div class="card-header">
          <h3 class="card-title">Daftar Product Terbaru</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <ul class="products-list product-list-in-card pl-2 pr-2" id="hasilPro4">

          </ul>
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-center">
          <span style="cursor: pointer;" onclick='document.location.href="<?= base_url() ?>/produk"' class="uppercase">Lihat Semua Products</span>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </div>

    <div class="col-md">

      <!-- PRODUCT LIST -->
      <div class="card card-outline card-success g-tema">
        <div class="card-header">
          <h3 class="card-title">Daftar Customer</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <ul class="products-list product-list-in-card pl-2 pr-2" id="hasilCus4">

          </ul>
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-center">
          <span style="cursor: pointer;" onclick='document.location.href="<?= base_url() ?>/customer"' class="uppercase">Lihat Semua Customer</span>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </div>
  </div>

  <div class="row">
    <div class="col-md">
      <div id="res"></div>
    </div>
  </div>

</div>