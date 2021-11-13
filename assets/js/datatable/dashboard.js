$(function(){

	const tipis = $('#stok-tipis').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "dashboard/get_stok_tipis_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "id_barang"},
		{"data" : "barcode"},
		{"data": "nama_barang"},
		{"data": "stok"}
		],
	})

	const habis = $('#stok-habis').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "dashboard/get_stok_habis_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "id_barang"},
		{"data" : "barcode"},
		{"data": "nama_barang"},
		{"data": "stok"}
		],
	})

})