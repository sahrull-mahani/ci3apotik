<?php foreach ($produk4 as $pdk) : ?>
  <li class="item g-tema">
    <div class='product-info'>
      <p class='product-title'><?= $pdk['nama_alat']; ?><span class='badge badge-info float-right'><?= rupiah($pdk['harga']) ?></span></p><span class='product-description'>Expired Pada Tanggal <em class='text-danger'><?= $pdk['expired'] ?></em></span>
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