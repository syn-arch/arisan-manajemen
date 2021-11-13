$(function(){

	const serviceTable = $('#table-service').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "service/get_service_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "id_service"},
		{"data": "tgl_service"},
		{"data": "tgl_ambil"},
		{"data": "nama_karyawan"},
		{"data": "nama_pelanggan"},
		{"data": "status"},
		{
			"data": "total_bayar",
			render: $.fn.dataTable.render.number( '.', '.', 0, '')
			
		},
		{
			"data": "id_service",
			"render" : function(data, type, row) {
				return `
				<a title="ubah" class="btn btn-warning" href="${base_url}service/ubah/${data}"><i class="fa fa-edit"></i></a>
				<a title="cetak invoice" class="btn btn-info" href="${base_url}service/invoice_cetak/${data}"><i class="fa fa-print"></i></a>
				<a title="hapus" class="btn btn-danger hapus_service" data-href="${base_url}service/hapus/${data}"><i class="fa fa-trash"></i></a>`
			}
		}
		],
	})

	$(document).on('click', '.hapus_service', function(){
		hapus($(this).data('href'))
	})

})