$(function(){

	const biayaTable = $('#table-biaya').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "biaya/get_biaya_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "id_biaya"},
		{"data": "tgl"},
		{"data": "nama_petugas"},
		{"data": "nama_outlet"},
		{"data": "keterangan_biaya"},
		{
			"data": "total_bayar",
			render: $.fn.dataTable.render.number( '.', '.', 0, '')
		},
		{"data": "keterangan"},
		{"data": "status"},
		{
			"data": "id_biaya",
			"render" : function(data, type, row) {
				return `
				<a title="ubah" class="btn btn-warning" href="${base_url}biaya/ubah/${data}"><i class="fa fa-edit"></i></a>
				<a title="hapus" class="btn btn-danger hapus_biaya" data-href="${base_url}biaya/hapus/${data}"><i class="fa fa-trash"></i></a>`
			}
		}
		],
	})

	$(document).on('click', '.hapus_biaya', function(){
		hapus($(this).data('href'))
	})

})