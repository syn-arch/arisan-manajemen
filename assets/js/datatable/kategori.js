$(function(){

	const kategoriTable = $('#table-kategori').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "master/get_kategori_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "id_kategori"},
		{"data": "nama_kategori"},
		{
			"data": "id_kategori",
			"render" : function(data, type, row) {
				return `<a title="ubah" class="btn btn-warning" href="${base_url}master/ubah_kategori/${data}"><i class="fa fa-edit"></i></a>
				<a title="hapus" class="btn btn-danger hapus_kategori" data-href="${base_url}master/hapus_kategori/${data}"><i class="fa fa-trash"></i></a>`
			}
		}
		],
	})

	$(document).on('click', '.hapus_kategori', function(){
		hapus($(this).data('href'))
	})

})