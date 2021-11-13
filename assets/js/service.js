$(function () {

	$(document).on('click','.hapus-service', function(){
		$(this).closest('tr').remove();
	});

	function tambahservice()
	{
		const jenis_barang = $('.jenis_barang').val();
		const kerusakan = $('.kerusakan').val();
		const garansi = $('.garansi').val();
		const keterangan = $('.keterangan').val();

		$('.detail-service').append(`
			<tr>
			<td><input type="text" class="form-control" readonly name="jenis_barang[]" value="${jenis_barang}"></td>
			<td><input type="text" class="form-control" readonly name="kerusakan[]" value="${kerusakan}"></td>
			<td><input type="text" class="form-control" readonly name="garansi[]" value="${garansi}"></td>
			<td><input type="text" class="form-control" readonly name="keterangan[]" value="${keterangan}"></td>
			<td><a href="#" class="btn btn-danger hapus-service"><i class="fa fa-trash"></i></a></td>
			</tr>
			`);


		$('.jenis_barang').val('');
		$('.kerusakan').val('');
		$('.garansi').val('');
		$('.keterangan').val('');
		$('.jenis_barang').focus();
	}

	$('.tambah-service').click(function(e){
		e.preventDefault();
		tambahservice();
	});
});
