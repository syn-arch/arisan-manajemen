$(function(){

	myTable = $('#table-cari-barang').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],
		"keys": {
			keys: [ 13 /* ENTER */, 38 /* UP */, 40 /* DOWN */ ]
		},
		"ajax": {
			"url": base_url + "barang/get_barang_json/",
			"type": "POST"
		},
		"columns": [
		{"data" : "id_barang"},
		{"data": "nama_barang"},
		{"data": "satuan"},
		{"data": "stok_q"},
		{
			"data": "harga_pokok",
			render: $.fn.dataTable.render.number( '.', '.', 0, '')
		}
		],
	})

	$('#table-cari-barang').on('key-focus.dt', function(e, datatable, cell){
		$(myTable.row(cell.index().row).node()).addClass('selected');
	});

	$('#table-cari-barang').on('key-blur.dt', function(e, datatable, cell){
		$(myTable.row(cell.index().row).node()).removeClass('selected');
	});

	$('#table-cari-barang').on('key.dt', function(e, datatable, key, cell, originalEvent){
		className = $(originalEvent.target).attr("class").split(/\s+/)[1];

		if (className != 'cash') {
			if(key == 13){
				var data = myTable.row(cell.index().row).data();
				tambah_chart(data.id_barang);
			}
		}
	});       

	$('#table-cari-barang').on('dblclick','tr',function(e){
		e.stopPropagation()                       
		id = myTable.rows(this).data()[0].id_barang
		tambah_chart(id);
	})

	// slight update to account for browsers not supporting e.which
	function disableF5(e) { 
		if ((e.which || e.keyCode) == 116){
			e.preventDefault(); 	
			swal({
				title: "Apakah anda yakin?",
				text: "Transaksi akan dibatalkan!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			}).then((willDelete) => {
				if (willDelete) {
					location.reload(true)
				}
			});
		} 
	};

	// disable refresh
	$(document).on("keydown", disableF5);


	$('.diskon_wrap').hide();
	$('.potongan_wrap').hide();
	$('.total_wrap').hide();

	$('.no_debit').hide()
	$('.no_kredit').hide()
	$('.lampiran').hide()

	$('.metode_pembayaran').change(function(){
		const val = $(this).val()
		if (val == 'Cash') {
			$('.no_debit').hide()
			$('.no_kredit').hide()
			$('.lampiran').hide()
		}else{
			$('.no_debit').show()
			$('.no_kredit').show()
			$('.lampiran').show()
		}
	})

	$(document).on('keyup', '.harga_pokok', function(){
		harga_pokok = $(this).val();
		qty = $(this).closest('tr').find('input[name="jumlah[]"]').val()
		total = parseInt(harga_pokok) * parseFloat(qty)

		$(this).closest('tr').find('td.subtotal').text(toRupiah(total, true))
		updateKembalian();
		get_subtotal();
	});

	function tambah_chart(id, qty = '1')
	{
		if (qty == '') {
			qty = 1;
		}

		$.get(base_url + 'master/get_barang/' + id, function(res){
			const data = JSON.parse(res);

			if (data == null) {
				swal({
					title: "Error!",
					text:  "Barang tidak ditemukan!",
					icon: "error",
					timer : 1500
				});
				$('.barcode').focus();
				return
			}

			const cari = $(document).find('tr[data-id="'+data.id_barang+'"]');

			if (cari.length > 0) {

				swal({
					title: "Error!",
					text: "Barang Sudah ditambahkan",
					icon: "error",
					timer: 1500,
					buttons : false
				});

				return
				
			}else{
				$('.pembelian-item').append(
					`
					<tr data-id="${data.id_barang}">
					<input type="hidden" name="id_barang[]" value="${data.id_barang}">
					<td>${data.nama_pendek}</td>
					<td><input class="form-control harga_pokok" autocomplete="off" name="harga_pokok[]" data-id="${data.id_barang}" type="text" value="${data.harga_pokok}"></td>
					<td><input class="form-control qty" autocomplete="off" step="0.1" name="jumlah[]" data-id="${data.id_barang}" data-harga="${data.harga_pokok}" type="number" value="${qty}" style="width: 5em"></td>
					<td class="subtotal" data-kode="${data.id_barang}">${toRupiah(data.harga_pokok * qty,true)}</td>
					<td>
					<a class="btn btn-danger btn-flat btn-block hapus-barang" data-id="${data.id_barang}" data-harga="${data.harga_pokok}"><i class="fa fa-trash"></i></a>
					</td>
					</tr>
					<tr style="display: block;" data-my-id="${data.id_barang}">
					<td><input autocomplete="off" type="text" name="golongan_1[]" class="form-control" placeholder="Golongan 1" value="${data.golongan_1}"></td>
					<td><input autocomplete="off" type="text" name="golongan_2[]" class="form-control" placeholder="Golongan 2" value="${data.golongan_2}"></td>
					<td><input autocomplete="off" type="text" name="golongan_3[]" class="form-control" placeholder="Golongan 3" value="${data.golongan_3}"></td>
					<td><input autocomplete="off" type="text" name="golongan_4[]" class="form-control" placeholder="Golongan 4" value="${data.golongan_4}"></td>
					<td><input type="text"class="form-control" disabled></td>
					</tr>
					`
					);	
			}

			$('.barcode').val('');
			$('.qty_brg').val('');
			$('.barcode').focus();

			updateKembalian();
			get_subtotal();
			updateTotalItem()
			myTable.cell.blur();
			
		})
	}

	$(document).on('click', '.harga-barang', function(){
		id = $(this).data('id')
		$("tr[data-my-id='"+id+"']").css({"display" : "block"})
	})

	$('.qty_brg').keydown(function (e) {
		const id = $('.barcode').val();
		const qty = $(this).val();
		if (e.which == '13') {
			e.preventDefault();
			e.stopPropagation();
			tambah_chart(id, qty);
			$('.barcode').val('');
			$('.barcode').focus();
		}
	})  

	$('.barcode').keydown(function (e) {
		const id = $(this).val();
		const qty = $('.qty_brg').val();
		if (e.which == '13') {
			e.preventDefault();
			e.stopPropagation();
			tambah_chart(id, qty);
			$('.barcode').val('');
			$('.barcode').focus();
		}
	})  

	function get_subtotal() {
		let total = 0;
		$(document).find('.subtotal').each(function (index, element) {
			total += parseInt($(element).text().replace('Rp. ', '').replace('.', '').replace('.', '').replace('.', ''));
		});

		$('.jumlah_bayar').val(toRupiah(total));
		$('.total_jumlah_bayar').val(toRupiah(total));

		return total;
	}

	function updateKembalian() {
		let subtotal = get_subtotal();
		const cash = $(document).find('.cash').val();
		if (parseFloat(cash) > 0) {
			const baru = cash - subtotal;
			$('.kembalian').val(toRupiah(baru));
		}
	}

	$(document).on('click', '.tambah-barang', function(){
		const id = $(this).data('id'); 
		tambah_chart(id);
	})

	$(document).on('click','.hapus-barang', function(e){
		e.preventDefault();
		id = $(this).data('id')
		$("tr[data-my-id='"+id+"']").remove()
		$("tr[data-id='"+id+"']").remove()
		updateKembalian();
		get_subtotal();
		updateTotalItem();
	})

	$(document).on('click', '.batal', function(e){
		e.preventDefault();
		remove('pembelianitem');
		$('.pembelian-item').html('');
		$('.harga').html('Rp. 0');
		$('.kembalian').html('');
		$('.cash').val('');
		$('.kembalian').val('');
		$('.jumlah_bayar').val('Rp. 0');
		$('.total_jumlah_bayar').val('Rp. 0');
		$('.barcode').focus();
	})


	$('.cash').keyup(function (e) {
		$(this).val(formatRupiah($(this).val()));

		cash = $(this).val().replace('.', '').replace('.', '').replace('.', '');
		const jumlah = parseFloat($('.jumlah_bayar').val().replace('Rp. ', '').replace('.', '').replace('.', '').replace('.', ''));

		const member = $('.member').val();

		jumlahAkhir = jumlah;

		let kembalian = toRupiah(parseFloat(cash) - parseFloat(jumlahAkhir));
		if (kembalian == 'Rp. NaN') {
			kembalian = "Rp. 0";
		}
		$('.kembalian').val(kembalian);
	})

	$(document).on('keyup change', '.qty', function(e){
		qty = $(this).val();
		harga_pokok = $(this).closest('tr').find('input[name="harga_pokok[]"]').val()

		total = Math.round(parseFloat(qty) * parseInt(harga_pokok));
		$(this).closest('tr').find('td.subtotal').text(toRupiah(total,true))

		get_subtotal();
		updateKembalian();

	})

	$(document).on('keydown', '.qty', function(e){
		if (e.which == 13) {
			$('.barcode').focus();
			return false;
		}
	})


	$('.barcode').keydown(function(e){
		const id = $(this).val();
		if (e.which == '13') {
			e.preventDefault();
			e.stopPropagation();
			tambah_chart(id);
			$(this).val('');
			$(this).focus();
		}
	})

	function updateTotalItem() {
		let total = 0;
		$(document).find('.qty').each(function (index, element) {
			total += 1
		});

		$('.total_item').val(total)

	}


	// shortcut
	function shortcut(e) {

        if (e.keyCode == 112) { // F1
        	e.preventDefault();

        	search = $('.barcode').val();
        	myTable.search(search).draw();

        	setTimeout(function() {               
        		myTable.row(':eq(0)', { page: 'current' }).select();
        		myTable.cell( ':eq(0)' ).focus();
        		if (!myTable.data().any()) {
        			$('.form-control.input-sm').focus()
        		}
        		$('.form-control.input-sm').focus()
        	}, 500);
        }
        if (e.keyCode == 114) { // F3
        	e.preventDefault();
        	$('.barcode').focus()
        }
        if (e.keyCode == 115) { // F4
        	e.preventDefault();
        	$('#modal-pembayaran').modal('show'); 

        	setTimeout(function(){
        		$('.cash').focus()
        	},500)
        }
    }

    // shortcut
    $(document).on('keyup keydown', 'input', function (e) {
    	shortcut(e);
    });

    $(document).on('keyup keydown', function (e) {
    	shortcut(e);
    });

})