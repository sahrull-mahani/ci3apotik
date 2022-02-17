function play() {
	var audio = new Audio('assets/audio/done.mp3')
	audio.play()
}

function makeTimer(time = $("#nowTimeCount").data("timer")) {

// 	var endTime = new Date("27 Jan 2022 12:56:00 "+ " GMT+08:00");			
	var endTime = new Date(time + " GMT+08:00");			
		endTime = (Date.parse(endTime) / 1000);

	var now = new Date();
		now = (Date.parse(now) / 1000);

	var timeLeft = endTime - now;

	var days = Math.floor(timeLeft / 86400); 
	var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
	var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
	var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

	if (hours < "10") { hours = "0" + hours; }
	if (minutes < "10") { minutes = "0" + minutes; }
	if (seconds < "10") { seconds = "0" + seconds; }

	$("#days").html(days + "<span> hari</span>");
	$("#hours").html(hours + "<span> jam</span>");
	$("#minutes").html(minutes + "<span> menit</span>");
	$("#seconds").html(seconds + "<span> detik</span>");
	
	if(days<= "0" && hours <= "00" && minutes <= "00" && seconds <= "60") {
	    $("#days").addClass('text-danger')
	    $("#hours").addClass('text-danger')
	    $("#minutes").addClass('text-danger')
	    $("#seconds").addClass('text-danger')
	}
	
	if(days <= "0" && hours <= "00" && minutes <= "00" && seconds <= "00") {
	    $("#timer").html('Time to logout!!')
	    window.location.href = location.origin + "/ci3apotik/home/logout"
	}

}
setInterval(function() {
    makeTimer();
}, 1000);


/* Fungsi formatRupiah */
function formatRupiah(angka, prefix){
	var number_string = angka.replace(/[^,\d]/g, '').toString(),
	split   		= number_string.split(','),
	sisa     		= split[0].length % 3,
	rupiah     		= split[0].substr(0, sisa),
	ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	if(ribuan){
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
	}

	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

// [GANTI TEMA]
function darkTheme() {
	$("#dark-theme").addClass('d-none')
	$("#light-theme").removeClass('d-none')
	$("#light-theme").addClass('rounded-left')
	$("#light-theme").removeClass('rounded-right')
	$("#blue-theme").removeClass('d-none')
	$(".wrapper").addClass('dark-bg-01')
	$(".wrapper").removeClass('blue-bg-01')
	if($(".main-header").hasClass('blue-bg-02')) {
		$(".main-header").switchClass('navbar-light blue-bg-02', 'navbar-dark bg-dark')
		$(".main-sidebar").removeClass('blue-bg-04')
	}else{
		$(".main-sidebar").removeClass('blue-bg-04')
		$(".main-header").switchClass('navbar-light bg-light', 'navbar-dark bg-dark')
	}
	$(".content-wrapper").addClass('dark-bg-01')
	$(".content-wrapper").removeClass('blue-bg-01') // dari blue theme
	$(".main-footer").addClass('bg-dark')
	$(".main-footer").removeClass('blue-bg-02') // dari blue theme
	$(".g-tema").addClass('bg-dark')
	$(".g-tema").removeClass('blue-bg-02') // dari blue theme
	$(".content-header").addClass('text-white')
	$(".g-tema-font").addClass('text-white')
	$(".preloader").addClass('dark-bg-loader')
	$(".preloader").removeClass('blue-bg-loader light-bg-loader')
}

function lightTheme() {
	$("#light-theme").addClass('d-none')
	$("#dark-theme").removeClass('d-none')
	$("#blue-theme").removeClass('d-none')
	$(".wrapper").removeClass('dark-bg-01 blue-bg-02')
	if($(".main-header").hasClass('navbar-light')) {
		$(".main-header").switchClass('blue-bg-03', 'bg-light')
		$(".main-sidebar").removeClass('blue-bg-04')
	}else{
		$(".main-header").switchClass('navbar-dark bg-dark', 'navbar-light bg-light')
		$(".main-sidebar").removeClass('blue-bg-04')
	}
	$(".content-wrapper").removeClass('dark-bg-01 blue-bg-01')
	$(".main-footer").removeClass('bg-dark blue-bg-02')
	$(".g-tema").removeClass('bg-dark blue-bg-02')
	$(".content-header").removeClass('text-white')
	$(".preloader").removeClass('blue-bg-loader dark-bg-loader')
	$(".preloader").addClass('light-bg-loader')
}

function blueTheme() {
	$("#blue-theme").addClass('d-none')
	$("#dark-theme").removeClass('d-none')
	$("#light-theme").addClass('rounded-right')
	$("#light-theme").removeClass('rounded-left')
	$("#light-theme").removeClass('d-none')
	$(".wrapper").removeClass('dark-bg-01')
	$(".wrapper").addClass('blue-bg-01')
	if($(".main-header").hasClass('navbar-light')) {
		$(".main-header").switchClass('bg-light', 'blue-bg-02')
		$(".main-sidebar").addClass('blue-bg-04')
	}else{
		$(".main-header").switchClass('navbar-dark bg-dark', 'navbar-light blue-bg-03')
		$(".main-sidebar").addClass('blue-bg-04')
	}
	$(".content-wrapper").removeClass('dark-bg-01') // dari dark theme
	$(".content-wrapper").addClass('blue-bg-01')
	$(".main-footer").removeClass('bg-dark') // dari dark theme
	$(".main-footer").addClass('blue-bg-02')
	$(".g-tema").removeClass('bg-dark') // dari dark theme
	$(".g-tema").addClass('blue-bg-02')
	$(".content-header").removeClass('text-white')
	$(".preloader").addClass('blue-bg-loader')
	$(".preloader").removeClass('dark-bg-loader light-bg-loader')
}

if(localStorage.getItem('tema') == 'dark') {
	darkTheme()
}else if(localStorage.getItem('tema') == 'light') {
	lightTheme()
}else if(localStorage.getItem('tema') == 'blue') {
	blueTheme()
}else{
	lightTheme()
}

$("#dark-theme").on('click', () => {
	localStorage.setItem('tema', 'dark')
	darkTheme()
	toastr.success('tema dark')
})
$("#light-theme").on('click', () => {
	localStorage.setItem('tema', 'light')
	lightTheme()
	toastr.success('tema light')
})
$("#blue-theme").on('click', () => {
	localStorage.setItem('tema', 'blue')
	blueTheme()
	toastr.success('tema blue')
})

$(document).ready(function() {
    // Loading
  	$(".preloader").fadeTo(500, 0).slideUp(500, function(){
  		$(this).remove()
  	});
  	$("img.wait-preloader").switchClass("d-block", "d-none")
    setTimeout(function(){
        $(".wait-preloader").next().removeClass('d-none')
    }, 700)
    
    $("#timer").on('click', function(e) {
        e.preventDefault()
        Swal.fire({
    		title: 'Pertanyaan',
    		text: "Apakah anda ingin menambah sesi anda selama 2 hari?",
    		type: "info",
    		showCancelButton: true,
    		confirmButtonColor: '#1e377f',
    		cancelButtonColor: '#b4bbc4',
    		confirmButtonText: 'Tambahkan!'
    	}).then((result) => {
    		if (result.value) {
    		    $.ajax({
                    type: 'post',
                    url: location.origin + '/ci3apotik/home/tambahwaktulogin',
                    success: function(data) {
                        toastr.success("Sesi anda bertambah 2 hari")
                        $("#nowTimeCount").data("timer", data)
                    },error: function(error) {
                        toastr.error(error)
                    }
                })	
    		}
    	})
    })

		

	// disable href in same page
	let urlNow = location.href
	$('a').on('click', function(e) {
		const href = $(this).attr('href')
		if (href == urlNow) {
			e.preventDefault()
			toastr.error("Anda masih dihalaman yang sama!")
		}
	})

	$('#inputGroupFile02').on('change', function() {
			// Ambil nama file 
			let fileName = $(this).val().split('\\').pop();
			// Ubah "Choose a file" label sesuai dengan nama file yag akan diupload
			$(this).next('.custom-file-label').addClass("selected").html(fileName);
		});

		  //Initialize Select2 Elements
		  $('select[name=alatSelect]').select2({
		  	theme: 'bootstrap4',
		  	placeholder: 'Pilih Alat'
		  });

			//Initialize Select2 Elements
			$('#customerSelect').select2({
				theme: 'bootstrap4',
				placeholder: 'Pilih Customer'
			});

			// Minimal Value Jumlah
			$("#jumlah").prop('min', 0);
			
			// tooltips
			$('[data-toggle="tooltip"]').tooltip()

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

	// autoNumeric
	$("input[name=harga]").autoNumeric('init');
	
	// datePicker
	$('.tanggal').flatpickr({
	    dateFormat: "d/m/Y",
	    minDate: "today" 
	})

	// pesan ci4
	const pesan = $('.pesan').data('pesan')
	const info = $('.pesanInfo').data('pesan')
	const warning = $('.warning').data('pesan')
	const gagal = $('.gagal').data('pesan')
	const pesanToast = $('.pesanToast').data('pesan')
	if (pesan){
		Swal.fire({
			title: 'Success',
			text: pesan,
			type: "success"
		})
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
	}else if (gagal) {
		Swal.fire({
			title: 'Gagal',
			html: gagal,
			type: "error"
		})
	}else if (warning) {
		Swal.fire({
			title: 'Warning',
			html: warning,
			type: "warning"
		})
	}

	// hapus
	$(".hapus").on('click', function(e) {
		e.preventDefault();
		const href = $(this).attr('href');

		Swal.fire({
			title: 'Anda yakin?',
			text: "Data akan dihapus secara permanen dari database!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yakin!'
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		})
	})

	// reset Password
	$(".resetpass").on('click', function(e) {
		e.preventDefault();
		const href = $(this).attr('href');

		Swal.fire({
			title: 'Anda yakin?',
			html: 'Password akan di set menjadi <b>qwerty12345</b>!',
			type: "question",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ubah!'
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
				// Push.create("Data telah direset")
			}
		})
	})

	// logout
	$(".keluar").on('click', function(e) {
		e.preventDefault();
		const href = $(this).attr('href');

		Swal.fire({
			title: 'Anda yakin?',
			text: "Anda akan Logout",
			type: "question",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yakin!'
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		})
	})

	// Data Tables
	$('#example1').DataTable( {
		"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
		"rowReorder": {selector: 'td:nth-child(3)'},
		"responsive": true,
		"language" 	: {
			"infoEmpty"			: "Data Kosong",
			"zeroRecords"		: "Maaf - Data Tidak Ditemukan",
			"searchPlaceholder"	: "Cari Data..."
		}
	});

	$("#blinkk").fadeOut('slow').fadeIn(1000)

	// Alert Close
	setTimeout(function() {
		$(".alertTimeOut").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
		});
	}, 5000)

	// Get Jumlah Stok
	$("#alatSelect").change(function() {
		const newUrl = location.origin + '/ci3apotik/distribusi/jumlahStok'
		let dataAlat   = $(this).val()
		let dataSplit  = dataAlat.split("|", 1)
		let dataString = "alat="+dataSplit
		$.ajax({
			type	: 'POST',
			url		: newUrl,
			data 	: dataString,
			success	: function(data) {
				const dataSplit = data.split('|')
				$("#stok").val(dataSplit[0])
				$("#harga").html(formatRupiah(dataSplit[1], 'Rp. '))
			}
		})

	})

	// CEK DISKON INPUT
	$("#disc").keyup(function() {

		if (/\D/g.test(this.value)) {
				// Filter non-digits from input value.
				this.value = this.value.replace(/\D/g, '');
			}

			if ( $(this).val() > Math.max(100) ) {
				$(this).val(100)
			}

		})

	// Cek stok
	$("#jumlah").keyup(function() {
		let dataAlat = $("#stok").val()

		if (/\D/g.test(this.value)) {
				// Filter non-digits from input value.
				this.value = this.value.replace(/\D/g, '');
			}

			if ( $(this).val() > Math.max(dataAlat) ) {
				Swal.fire({
					title: 'Gagal',
					text: "Jumlah yang dimasukan melebihi stok!",
					type: "error"
				})
				$(this).val("");
			}
		})

	// simpan alat customer
	$("#simpan").click(function() {
		let inputCustomer = $("#customerSelect").val()
		if (inputCustomer === '') {
			Swal.fire({
				title: 'Pesan!',
				text: "Pastikan Anda sudah memillih customer yang ingin di tuju!",
				type: "warning"
			})
		}else {

			$.ajax({
				type	: 'POST',
				url		: "simpan",
				data 	: "customer="+inputCustomer,
				success	: function(data) {

					if (data === 'berhasil') {
						Swal.fire({
							title: 'Success',
							text: "Data Berhasil Disimpan",
							type: "success"
						}).then((result) => {
							if (result.value) {
								window.location.href = '/distribusi'
							}
						})
					}else{
						Swal.fire({
							title: 'Gagal',
							text: "Data Gagal Disimpan!!",
							type: "error"
						})
					}

				}
			})

		}
	})

	// saat diupdate customer
	$("#update").click(function() {
		const newUrl = location.origin + '/ci3apotik/distribusi/simpanEdit'

		let inputCustomer = $("#customerSelect").val()

		$.ajax({
			type	: 'POST',
			url		: newUrl,
			data 	: "customer="+inputCustomer,
			success	: function(data) {

				if (data === 'berhasil') {
					Swal.fire({
						title: 'Success',
						text: "Data Berhasil Disimpan",
						type: "success"
					}).then((result) => {
						if (result.value) {
							window.location.href = newUrl
						}
					})
				}else{
					Swal.fire({
						title: 'Gagal',
						text: "Data Gagal Disimpan!!",
						type: "error"
					})
				}

			}
		})

	})


});