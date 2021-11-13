$(function(){
	$('#table-stok-outlet').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "barang/get_barang_by_outlet_json/" + id_outlet,
			"type": "POST"
		},
		"columns": [
		{"data" : "id_barang"},
		{"data": "nama_barang"},
		{"data": "stok_outlet"},
		{
			"data": "id_stok_outlet",
			"render" : function(data, type, row) {
				return `
				<a title="ubah" class="btn btn-warning" href="${base_url}stok/ubah_stok_barang/${data}"><i class="fa fa-edit"></i></a>`
			}
		}
		],
	})
})