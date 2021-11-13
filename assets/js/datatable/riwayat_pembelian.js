$(function(){

	const petugasTable = $('#table-riwayat-pembelian').dataTable({ 
		"processing": true,
		"serverSide": true,
		"pageLength" : 50,
		"order": [],
		"ajax": {
			"url": base_url + "laporan/get_riwayat_pembelian_json",
			"type": "POST"
		},
		"columns": [
		{
			orderable : false,
			"data": "faktur_pembelian",
			"render" : function(data, type, row){
				return `<input type="checkbox" class="data_checkbox" name="faktur_pembelian[]" value="${data}">`
			}
		},
		{
			"data" : "faktur_pembelian"
		},
		{
			"data" : "tgl"
		},
		{
			"data" : "tgl_jatuh_tempo"
		},
		{
			"data": "nama_supplier"
		},
		{
			"data": "nama_petugas"
		},
		{
			"data": "total_bayar",
			render: $.fn.dataTable.render.number( '.', '.', 0, '')
		},
		{
			searchable : false,
			"data": "cash",
			render: $.fn.dataTable.render.number( '.', '.', 0, '')
		},
		{
			searchable : false,
			"data": "sisa_bayar",
			"render" : function(data, type, row) {
				if(data < 0){
					return '0'
				}
				return toRupiah(data, true)
			}
		},
		{
			searchable : false,
			"data" : "status",
			"render" : function(data, type, row) {
				if(data == 'Lunas'){
					return `<button class="btn btn-success">LUNAS</button>`
				}
				return `<button class="btn btn-warning">BELUM LUNAS</button>`
			}
		},
		{
			searchable : false,
			"data": "faktur_pembelian",
			"render" : function(data, type, row) {
				return `
				<a title="invoice" class="btn btn-info" href="${base_url}pembelian/invoice/${data}"><i class="fa fa-eye"></i></a>
				<a title="ubah pembelian" class="btn btn-primary" href="${base_url}pembelian/ubah/${data}"><i class="fa fa-edit"></i></a>
				<a title="daftar pembayaran" class="btn btn-success" href="${base_url}pembelian/pembayaran/${data}"><i class="fa fa-list"></i></a>
				<a title="hapus pembelian" class="btn btn-danger hapus_riwayat_pembelian" data-href="${base_url}laporan/hapus_pembelian/${data}"><i class="fa fa-trash"></i></a>`
			}
		}
		],
	})

	$(document).on('click', '.hapus_riwayat_pembelian', function(){
		hapus($(this).data('href'))
	})

})