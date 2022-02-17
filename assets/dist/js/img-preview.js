function tampilkanPreview(gambar, idpreview) {
	var gb = gambar.files

	for (var i = 0; i < gb.length; i++) {
		var gbPreview 	= gb[i]
		var imageType 	= /image.*/;
		var preview 	= document.getElementById(idpreview)
		var reader		= new FileReader();

		if (gbPreview.type.match(imageType)) {
			preview.file 	= gbPreview
			reader.onload	= (function(element) {
				return function(e) {
					element.src = e.target.result;
				}
			})(preview)
			reader.readAsDataURL(gbPreview)
			$('#upProfil').removeClass("d-none")
		}else{
			// alert("Type File tidak sesuai!")
			Swal.fire({
				title: 'Type File tidak sesuai!',
				text: "Masukan file dengan extensi [jpg] [jpeg] [png]! Selain dari itu file tidak bisa di upload!",
				type: "error"
			})
		}
	}
}