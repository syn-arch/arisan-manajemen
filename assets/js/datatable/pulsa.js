$(function(){

	$('.harga_pulsa').keyup(function(){
		const harga = $(this).val()
		const saldo_awal = $('.saldo_awal').val()

		$('.saldo_akhir').val(saldo_awal - harga)
	})

	const pulsaTable = $('#table-pulsa').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "pulsa/get_pulsa_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "id_pulsa"},
		{"data": "tgl"},
		{"data": "nama_petugas"},
		{"data": "nama_outlet"},
		{"data": "no_telepon"},
		{
			"data": "saldo_awal",
			render: $.fn.dataTable.render.number( '.', '.', 0, '')
		},
		{
			"data": "harga_pulsa",
			render: $.fn.dataTable.render.number( '.', '.', 0, '')
		},
		{
			"data": "saldo_akhir",
			render: $.fn.dataTable.render.number( '.', '.', 0, '')
		},
		{"data": "keterangan"},	
		{
			"data": "id_pulsa",
			"render" : function(data, type, row) {
				return `
				<a title="ubah" class="btn btn-warning" href="${base_url}pulsa/ubah/${data}"><i class="fa fa-edit"></i></a>
				<a title="hapus" class="btn btn-danger hapus_pulsa" data-href="${base_url}pulsa/hapus/${data}"><i class="fa fa-trash"></i></a>`
			}
		}
		],
	})

	const riwayatSaldo = $('#table-riwayat-saldo').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "pulsa/get_riwayat_tambah_saldo_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "tgl"},
		{
			"data": "saldo_awal",
			render: $.fn.dataTable.render.number( '.', '.', 0, 'Rp. ')
		},
		{
			"data": "tambah_saldo",
			render: $.fn.dataTable.render.number( '.', '.', 0, 'Rp. ')
		},
		{
			"data": "saldo_akhir",
			render: $.fn.dataTable.render.number( '.', '.', 0, 'Rp. ')
		}
		],
	})

	$(document).on('click', '.hapus_pulsa', function(){
		hapus($(this).data('href'))
	})

})