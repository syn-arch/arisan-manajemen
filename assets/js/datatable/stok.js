$(function(){

	const barangTable = $('#table-stok').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "stok/get_stok_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "id_stok"},
		{"data": "tgl"},
		{"data": "nama_petugas"},
		{"data": "dari"},
		{"data": "ke"},
		{"data": "keterangan"},
		{
			"data": "id_stok",
			"render" : function(data, type, row) {
				return `<a title="detail stok"  class="btn btn-info" href="${base_url}stok/detail_stok/${data}"><i class="fa fa-eye"></i></a>
				<a title="Ubah Penyesuaian"  class="btn btn-warning" href="${base_url}stok/ubah_stok/${data}"><i class="fa fa-edit"></i></a>
				<a title="hapus penyesuaian"  class="btn btn-danger hapus_stok" data-href="${base_url}stok/hapus_stok/${data}"><i class="fa fa-trash"></i></a>`
			}
		}
		],
	});

	$(document).on('click', '.hapus_stok', function(){
		hapus($(this).data('href'))
	})
})