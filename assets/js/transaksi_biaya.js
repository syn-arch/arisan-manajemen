$(function () {


	$('.total_bayar').keyup(function(){
		$(this).val(formatRupiah($(this).val()));
	});

	$('.qty').keyup(function(){
		let qty = $(this).val();
		const harga = $('.harga').val();

		if (qty == '') qty = 0;
		$('.subtotal').val(parseInt(qty)*parseInt(harga));
	});

	function updateTotal()
	{
		let total = 0;
		$(document).find('.total_harga').each(function (index, element) {
			total += parseInt($(element).val());
		});
		$('.total_bayar').val(total);
	}

	function updateKembalian()
	{
		let cash = $('.cash').val();
		if (cash == '') cash = 0;
		const total_bayar = $('.total_bayar').val();
		const kembalian = parseInt(cash) - parseInt(total_bayar);
		$('.kembalian').val(kembalian);
	}

	$('.cash').keyup(function(){
		let cash = $(this).val();
		if (cash == '') cash = 0
			const total_bayar = $('.total_bayar').val();
		const kembalian = parseInt(cash) - parseInt(total_bayar);
		$('.kembalian').val(kembalian);
	})

	$(document).on('click','.hapus-biaya', function(){
		$(this).closest('tr').remove();
		updateTotal();
		updateKembalian();
	});

	function tambahBiaya()
	{
		const nama_biaya = $('.nama_biaya').val();
		const harga = $('.harga').val();
		const qty = $('.qty').val();
		const total_harga = $('.subtotal').val();

		$('.detail-biaya').append(`
			<tr>
			<td><input type="text" class="form-control" readonly name="nama_biaya[]" value="${nama_biaya}"></td>
			<td><input type="text" class="form-control" readonly name="harga[]" value="${harga}"></td>
			<td><input type="text" class="form-control" readonly name="qty[]" value="${qty}"></td>
			<td><input type="text" class="form-control total_harga" readonly name="total_harga[]" value="${total_harga}"></td>
			<td><a href="#" class="btn btn-danger hapus-biaya"><i class="fa fa-trash"></i></a></td>
			</tr>
			`);

		updateTotal();
		updateKembalian();

		$('.nama_biaya').val('');
		$('.harga').val('');
		$('.qty').val('');
		$('.subtotal').val('');
		$('.nama_biaya').focus();
	}

	$('.qty').keydown(function(e){
		if (e.keyCode == 13) {
			e.preventDefault();
			tambahBiaya();
		}
	})

	$('.tambah-biaya').click(function(e){
		e.preventDefault();
		tambahBiaya();
	});
});
