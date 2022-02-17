<?php if (empty($pesan)) : ?>
  <div class="card mb-1 g-tema">
    <div class="card-body">
      <h4 class="bold">Belum ada pesan</h4>
    </div>
  </div>
<?php endif ?>
<?php foreach ($pesan as $psn) : ?>
  <div class="card mb-1 shadow-sm <?= $this->data['session']['id'] == $psn['id_user'] ? 'bg-light' : 'bg-transparent' ?>">
    <div class="card-body rounded p-1 px-3">
      <div class="<?= $this->data['session']['id'] == $psn['id_user'] ? 'text-right text-success' : 'text-left' ?>">
        <small class="bold d-block text-capitalize"><?= $psn['nama']; ?></small> 
        <?= $psn['pesan']; ?>
        <br>
        <small class"font-italic text-left"><?= timepassHour($psn['time']); ?></small>
      </div>
    </div>
  </div>
<?php endforeach ?>