$(function(){

	const petugasTable = $('#table-riwayat-pengembalian').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "laporan/get_riwayat_pengembalian_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "faktur_pengembalian"},
		{"data" : "tgl"},
		{"data" : "nama_outlet"},
		{"data": "nama_pelanggan"},
		{"data": "nama_petugas"},
		{
			"data": "total_bayar",
			render: $.fn.dataTable.render.number( '.', '.', 0, 'Rp. ')
		},
		{
			"data" : "status",
			"render" : function(data,type,row){
				return `<select name="status" id="status" class="form-control status" data-id="${row.faktur_pengembalian}">
				<option value="menunggu" ${data == 'menunggu' ? 'selected' : ''}>Menunggu</option>
				<option value="diterima" ${data == 'diterima' ? 'selected' : ''}>Diterima</option>
				<option value="ditolak" ${data == 'ditolak' ? 'selected' : ''}> Ditolak</option>
				</select>`
			}
		},
		{
			"data": "faktur_pengembalian",
			"render" : function(data, type, row) {
				return `
				<a title="invoice" class="btn btn-info" href="${base_url}pengembalian/invoice/${data}"><i class="fa fa-eye"></i></a>
				<a title="hapus pengembalian" class="btn btn-danger hapus_riwayat_pengembalian" data-href="${base_url}laporan/hapus_pengembalian/${data}"><i class="fa fa-trash"></i></a>`
			}
		}
		],
	})

	$(document).on('change', '.status', function(){
		const faktur_pengembalian = $(this).data('id')
		const status = $(this).val()

		$.ajax({
			url : base_url + 'laporan/ubah_status_pengembalian',
			method : 'post',
			data : {
				faktur_pengembalian : faktur_pengembalian,
				status : status
			},
			success : function(e){
				swal({
					title: "Berhasil!",
					text:  "Status Berhasil Diubah!",
					icon: "success",
					timer : 1500
				});
				window.location.reload(true)
			}
		})
	})

	$(document).on('click', '.hapus_riwayat_pengembalian', function(){
		hapus($(this).data('href'))
	})

})