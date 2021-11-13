$(function(){

	const kelompokTable = $('#table-kelompok').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "master/get_kelompok_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "id_kelompok"},
		{"data": "nama_kelompok"},
		{
			"data": "id_kelompok",
			"render" : function(data, type, row) {
				return `<a title="ubah" class="btn btn-warning" href="${base_url}master/ubah_kelompok/${data}"><i class="fa fa-edit"></i></a>
				<a title="hapus" class="btn btn-danger hapus_kelompok" data-href="${base_url}master/hapus_kelompok/${data}"><i class="fa fa-trash"></i></a>`
			}
		}
		],
	})

	$(document).on('click', '.hapus_kelompok', function(){
		hapus($(this).data('href'))
	})

})