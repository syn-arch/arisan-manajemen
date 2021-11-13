$(function(){

	const karyawanTable = $('#table-karyawan').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "master/get_karyawan_json",
			"type": "POST"
		},
		"columns": [
		{"data" : "id_karyawan"},
		{"data": "nama_outlet"},
		{"data": "nama_karyawan"},
		{"data": "alamat"},
		{"data": "jk"},
		{"data": "telepon"},
		{"data": "email"},
		{"data": "jabatan"},
		{
			"data": "id_karyawan",
			"render" : function(data, type, row) {
				return `<a title="ubah" class="btn btn-warning" href="${base_url}karyawan/ubah/${data}"><i class="fa fa-edit"></i></a>
				<a title="hapus" class="btn btn-danger hapus_karyawan" data-href="${base_url}karyawan/hapus/${data}"><i class="fa fa-trash"></i></a>`
			}
		}
		],
	})

	$(document).on('click', '.hapus_karyawan', function(){
		hapus($(this).data('href'))
	})

})