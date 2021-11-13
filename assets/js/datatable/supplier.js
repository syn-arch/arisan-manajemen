$(function(){

	const supplierTable = $('#table-supplier').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "master/get_supplier_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "id_supplier"},
		{"data": "nama_supplier"},
		{"data": "alamat"},
		{"data": "telepon"},
		{
			"data": "id_supplier",
			"render" : function(data, type, row) {
				return `<a title="ubah" class="btn btn-warning" href="${base_url}master/ubah_supplier/${data}"><i class="fa fa-edit"></i></a>
				<a title="hapus" class="btn btn-danger hapus_supplier" data-href="${base_url}master/hapus_supplier/${data}"><i class="fa fa-trash"></i></a>`
			}
		}
		],
	})

	$(document).on('click', '.hapus_supplier', function(){
		hapus($(this).data('href'))
	})

})