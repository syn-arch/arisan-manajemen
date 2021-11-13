$(function(){


	$('.log_out').click(function(e){
		e.preventDefault();

		const logout = $(this).attr('href')

		$.get(base_url + 'penjualan/get_register', function(res){


			if (res == "true") {
				swal({
					title: "Register Belum Ditutup",
					text: "Tutup Register Terlebih Dahulu Sebelum Logout?",
					icon: "warning",
					buttons: {
						cancel: "Tidak",
						catch: {
							text: "Iya",
							value: 1,
						},
					},
					dangerMode: true,
				}).then((willDelete) => {
					if (willDelete == 1) {
						window.location = base_url + 'penjualan/close_register';
					}else{
						window.location.href = logout;
					}
				});
			}else{
				window.location.href = logout;
			}

		})

	})

})