$(function(){

	const agenTable = $('#table-agen').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "master/get_agen_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "id_agen"},
		{"data": "nama_agen"},
		{"data": "alamat"},
		{"data": "telepon"},
		{"data": "nama_kelompok"},
		{"data": "nominal_kocokan"},
		{"data": "periode_arisan"},
		{"data": "keterangan"},
		{
			"data": "id_agen",
			"render" : function(data, type, row) {
				return `<a title="ubah" class="btn btn-warning" href="${base_url}agen/ubah/${data}"><i class="fa fa-edit"></i></a>
				<a title="hapus" class="btn btn-danger hapus_agen" data-href="${base_url}agen/hapus/${data}"><i class="fa fa-trash"></i></a>`
			}
		}
		],
	})

	$(document).on('click', '.hapus_agen', function(){
		hapus($(this).data('href'))
	})

})