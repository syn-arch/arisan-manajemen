$(function(){	

	$('#table-tambah-stok-opname').dataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + "barang/get_barang_by_outlet_json/" + id_outlet ,
			"type": "POST"
		},
		"columns": [
		{"data" : "id_barang"},
		{"data" : "barcode"},
		{"data": "nama_barang"},
		{"data" : "stok_outlet"},
		{
			"data": "id_barang",
			render : function(data, type, row){
				return `<button class="btn btn-success tambah_brg_opname" data-id="${data}"><i class="fa fa-plus"></i></button>`
			}
		}
		],
	})

	function tambah_brg(id){
		$.get(base_url + 'barang/get_barang_by_id/' + id + '/' + id_outlet, function(res){
			const data = JSON.parse(res)
			if (data == null) {
				swal({
					title: "Error!",
					text:  "Barang tidak ditemukan!",
					icon: "error",
					timer : 1500
				});
			}
			const cari = $(document).find('tr[id="'+data.id_barang+'"]');
			if (cari.length < 1) {
				const html = `<tr id="${data.id_barang}">
					<td><input readonly="" type="text" class="form-control" value="${data.id_barang}" name="id_barang[]"></td>
					<td><input readonly="" type="text" class="form-control" value="${data.barcode}" name="barcode[]"></td>
					<td>${data.nama_barang}</td>
					<td><input type="text" class="form-control" value="${data.stok_komputer}" name="stok_komputer[]"></td>
					<td><input type="text" class="form-control" placeholder="Stok Fisik" name="stok_fisik[]"></td>
					<td><a class="btn btn-danger hapus_brg" data-id="${data.id_barang}"><i class="fa fa-trash"></i></a></td>
					</tr>`

				$('.barang-stokopname').append(html)				
			}

		})
	}

	$('.cari_brg_stokopname').keydown(function(e){
		if (e.keyCode == 13) {
			e.preventDefault();
			tambah_brg($(this).val())
			$(this).val('')
			$(this).focus()
		}
	})

	$(document).on('click', '.tambah_brg_opname', function(e){
		tambah_brg($(this).data('id'))
	})

	$(document).on('click', '.hapus_brg', function(){
		$(this).closest('tr').remove();
	})
})