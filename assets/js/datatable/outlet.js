$(function(){

	const outletTable = $('#table-outlet').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "master/get_outlet_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "id_outlet"},
		{"data": "nama_outlet"},
		{"data": "alamat"},
		{"data": "telepon"},
		{"data": "email"},
		{
			"data": "id_outlet",
			"render" : function(data, type, row) {
				return `<a title="ubah" class="btn btn-warning" href="${base_url}master/ubah_outlet/${data}"><i class="fa fa-edit"></i></a>
				<a title="hapus" class="btn btn-danger hapus_outlet" data-href="${base_url}master/hapus_outlet/${data}"><i class="fa fa-trash"></i></a>`
			}
		}
		],
	})

	$(document).on('click', '.hapus_outlet', function(){
		hapus($(this).data('href'))
	})

})