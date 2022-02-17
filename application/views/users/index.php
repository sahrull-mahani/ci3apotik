<div class="container-fluid">

  <div class="row mt-4">
    <div class="col-md">

      <!-- USERS LIST -->
      <div class="card g-tema">
        <div class="card-header">
          <h3 class="card-title">Daftar User</h3>

          <div class="card-tools">
            <span class="badge badge-info"><?= count($users) <= 1 ? '0' : count($users); ?> user yang terdafatar</span>
            <span class="badge badge-success"><span id="totOn"><?= count($usersOn) < 1 ? '0' : count($usersOn); ?></span> user yang sedang online</span>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
          </div>
        </div>
        <!-- /.card-header -->
        <img src="<?= 'https://' . $_SERVER['HTTP_HOST'] ?>/assets/img/makna2-loading.gif" alt='loading...' width='150' class="mx-auto d-block wait-preloader d-none" />
        <div class="card-body p-0 d-none">
          <ul class="users-list clearfix">
            <?php foreach ($users as $r) : ?>
              <li>
                <img src="<?= base_url('assets'); ?>/img/profile.jpg" class="img-fluid img-thumbnail <?= $r['online'] == 1 ? 'bg-success' : ''; ?>" id="online-<?= $r['id']; ?>" data-id="<?= $r['id']; ?>" style="width: 100px;" alt="User Image">
                <p class="users-list-name mt-2 mb-0 g-tema-font" href="#"><?= ucwords($r['nama']); ?> <small class="badge badge-pill bg-success <?= $r['online'] == 0 ? 'd-none' : '' ?>" id="status-<?= $r['id']; ?>">online</small></p>
                <span class="users-list-date">
                  <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="users/hapus/<?= $r['id']; ?>" class="btn btn-sm btn-outline-danger hapus" class="fa fa-trash text-mute"><i class="fa fa-trash"></i> Hapus</a>
                    <a href="users/reset/<?= $r['id']; ?>" class="btn btn-sm btn-outline-danger resetpass" class="fa fa-trash text-mute"><i class="fa fa-undo-alt"></i> Reset Pass</a>
                  </div>
                </span>
              </li>
            <?php endforeach ?>
          </ul>
          <!-- /.users-list -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          PT.Makna Selaras | User List
        </div>
        <!-- /.card-footer -->
      </div>
      <!--/.card -->

    </div>
  </div>
</div>