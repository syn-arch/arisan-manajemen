$(".check_all").click(function(){
	if (this.checked) {
		$(".data_checkbox").prop("checked", true)
	}else{
		$(".data_checkbox").prop("checked", false)
	}
})

$(".hapus_bulk_riwayat_penjualan").click(function(e){
	e.preventDefault();

	var faktur_penjualan = [];

	$(':checkbox:checked').each(function(i){
		faktur_penjualan[i] = $(this).val();
	});

	if (faktur_penjualan.length == 0) {
		swal({
			title: "Gagal!",
			text: 'Anda Belum Memilih Data',
			icon: "error"
		})
		return 
	}

	swal({
		title: "Apakah anda yakin?",
		text: "Data yang dihapus tidak dapat dikembalikan!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {

			$.ajax({
				method : "post",
				url : base_url + 'laporan/hapus_bulk_riwayat_penjualan',
				data : { faktur_penjualan : faktur_penjualan},
				success : function(data){
					swal('Berhasil','Data berhail dihapus', 'success');
					window.location.href = base_url + 'laporan/riwayat_penjualan'
				}
			})

		}
	});
})

$(".hapus_bulk_riwayat_pembelian").click(function(e){
	e.preventDefault();

	var faktur_pembelian = [];

	$(':checkbox:checked').each(function(i){
		faktur_pembelian[i] = $(this).val();
	});

	if (faktur_pembelian.length == 0) {
		swal({
			title: "Gagal!",
			text: 'Anda Belum Memilih Data',
			icon: "error"
		})
		return 
	}

	swal({
		title: "Apakah anda yakin?",
		text: "Data yang dihapus tidak dapat dikembalikan!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {

			$.ajax({
				method : "post",
				url : base_url + 'laporan/hapus_bulk_riwayat_pembelian',
				data : { faktur_pembelian : faktur_pembelian},
				success : function(data){
					swal('Berhasil','Data berhail dihapus', 'success');
					window.location.href = base_url + 'laporan/riwayat_pembelian'
				}
			})

		}
	});
})