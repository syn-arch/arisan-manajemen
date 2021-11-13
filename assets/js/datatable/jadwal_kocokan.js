$(function(){

	const jadwal_kocokanTable = $('#table-jadwal_kocokan').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "master/get_jadwal_kocokan_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "id_jadwal_kocokan"},
		{"data": "nama_agen"},
		{"data": "nama_kelompok"},
		{
			"data": "nominal",
			render: $.fn.dataTable.render.number('.', '.', 0, '')
		},
		{"data": "tanggal"},
		{"data": "keterangan"},
		{
			"data": "id_jadwal_kocokan",
			"render" : function(data, type, row) {
				return `<a title="ubah" class="btn btn-warning" href="${base_url}master/ubah_jadwal_kocokan/${data}"><i class="fa fa-edit"></i></a>
				<a title="hapus" class="btn btn-danger hapus_jadwal_kocokan" data-href="${base_url}master/hapus_jadwal_kocokan/${data}"><i class="fa fa-trash"></i></a>`
			}
		}
		],
	})

	$(document).on('click', '.hapus_jadwal_kocokan', function(){
		hapus($(this).data('href'))
	})

})