$(function() {
  // Loading
	$(".preloader").fadeTo(500, 0).slideUp(500, function(){
		$(this).remove();
	});

	$("#push").click(function(e) {
		e.preventDefault()
		Push.create("HALLO DUNIA")
	})
  
  // login show hide password
	$("label[for=showPass]").click(function() {
		if ($("input[type=checkbox]").is(':checked')) {
			// Ubah Sembunyi
			$("input.ShowPass").attr("type", "password")
			$(".fa-lock-open").removeClass("fa-lock-open").addClass("fa-lock")
		}else{
			// Ubah Lihatkan
			$("input.ShowPass").attr("type", "text")
			$(".fa-lock").removeClass("fa-lock").addClass("fa-lock-open")
		}
  })
  
  // pesan ci4
	const gagal = $('.gagal').data('pesan')
	const pesan = $('.pesan').data('pesan')
	const info = $('.pesanInfo').data('pesan')
	const pesanToast = $('.pesanToast').data('pesan')
	if (pesan){
		Swal.fire({
			title: 'Success',
			text: pesan,
			type: "success"
		})
  }else if (gagal) {
    Swal.fire({
			title: 'Gagal',
			text: gagal,
			type: "error"
		})
		// Push.create(gagal)
	}else if (pesanToast) {
		toastr.success(pesanToast)
	}else if (info) {
		Swal.fire({
			title: 'Informasi',
			html: info,
			type: "info",
			showCancelButton: true,
			confirmButtonText: 'OK!',
			cancelButtonText: 'Kembali!',
		}).then((result) => {
			if (result.value) {
				document.location.href = "/produk";
			}
		})
	}
})