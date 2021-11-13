$(function(){

	const petugasTable = $('#table-petugas').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "petugas/get_petugas_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "id_petugas"},
		{"data": "nama_petugas"},
		{"data": "alamat"},
		{"data": "jk"},
		{"data": "telepon"},
		{"data": "email"},
		{"data": "nama_role"},
		{
			"data": "id_petugas",
			"render" : function(data, type, row) {
				return `<a title="ubah" class="btn btn-warning" href="${base_url}petugas/ubah/${data}"><i class="fa fa-edit"></i></a>
				<a title="hapus" class="btn btn-danger hapus_petugas" data-href="${base_url}petugas/hapus/${data}"><i class="fa fa-trash"></i></a>`
			}
		}
		],
	})

	$(document).on('click', '.hapus_petugas', function(){
		hapus($(this).data('href'))
	})

})