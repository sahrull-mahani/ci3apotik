<?php foreach ($customer4 as $cus) : ?>
  <li class='item g-tema'>
    <div class='product-info'>
      <p class='product-title'><?= $cus['nama_customer']; ?><span class='badge badge-success float-right'><i class='fa fa-phone-alt'></i> <?= $cus['telp']; ?></span></p><span class='product-description'>Alamat : <?= $cus['alamat']; ?></span>
    </div>
  </li>
<?php endforeach ?>
<script>
  if (localStorage.getItem('tema') == 'dark') {
    $(".g-tema").addClass('bg-dark')
    $(".g-tema").removeClass('blue-bg-02')
  } else if (localStorage.getItem('tema') == 'light') {
    $(".g-tema").removeClass('bg-dark')
    $(".g-tema").removeClass('blue-bg-02')
  } else if (localStorage.getItem('tema') == 'blue') {
    $(".g-tema").removeClass('bg-dark')
    $(".g-tema").addClass('blue-bg-02')
  }
</script>