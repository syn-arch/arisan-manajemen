<section class="invoice">
	<!-- title row -->
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-shopping-cart"></i> E-POS - Bukti Pembelian
				<small class="pull-right">Tanggal: <?php echo date('d-m-Y', strtotime($pembelian['tgl'])) ?></small>
			</h2>
		</div>
		<!-- /.col -->
	</div>
	<!-- info row -->
	<div class="row invoice-info">
		<div class="col-xs-12 invoice-col">
			<address>
				<strong>Supplier : <?php echo $pembelian['nama_supplier'] ?></strong><br>
				Alamat	: <?php echo $pembelian['alamat'] ?><br>
				Telepon	:<?php echo $pembelian['telepon'] ?><br>
				Tanggal Pembelian	:<?php echo $pembelian['tgl_pembelian'] ?><br>
				Referensi	:<?php echo $pembelian['referensi'] ?><br>
				Jatuh Tempo	:<?php echo $pembelian['tgl_jatuh_tempo'] ?><br>
			</address>
		</div>
	</div>
	<!-- /.row -->

	<!-- Table row -->
	<div class="row">
		<div class="col-xs-12 table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Barang</th>
						<th>Harga</th>
						<th>Qty</th>
						<th>Subtotal</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					$this->db->join('barang', 'id_barang');
					$barang =  $this->db->get_where('detail_pembelian', ['faktur_pembelian' => $pembelian['faktur_pembelian']])->result_array();
					foreach ($barang as $row) : ?>
						<tr>
							<td><?php echo $no++ ?></td>
							<td><?php echo $row['nama_barang'] ?></td>
							<td><?php echo "Rp. " . number_format($row['harga_pokok']) ?></td>
							<td><?php echo $row['jumlah'] ?></td>
							<td><?php echo "Rp. " . number_format($row['harga_pokok'] * $row['jumlah']) ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->

	<div class="row">
		<!-- accepted payments column -->
		<div class="col-xs-6">
		</div>
		<!-- /.col -->
		<div class="col-xs-6">
			<p class="lead">Pembayaran</p>

			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<th style="width:50%">Total Item</th>
							<td><?php echo ($pembelian['total_item']) ?></td>
						</tr>
						<tr>
							<th style="width:50%">Total</th>
							<td><?php echo "Rp. " . number_format($pembelian['total_bayar']) ?></td>
						</tr>
						<tr>
							<th>Cash</th>
							<td><?php echo "Rp. " . number_format($total_bayar) ?></td>
						</tr>
						<?php if ($total_bayar >= $pembelian['total_bayar']): ?>
							<tr>
								<th>Kembalian</th>
								<td><?php echo "Rp. " . number_format($total_bayar - $pembelian['total_bayar']) ?></td>
							</tr>
						<?php else : ?>
							<tr>
								<th>Harus Dibayar</th>
								<td><?php echo "Rp. " . number_format($pembelian['total_bayar'] - $total_bayar) ?></td>
							</tr>
						<?php endif; ?>
					</tbody></table>
				</div>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->

		<!-- this row will not appear when printing -->
		<div class="row no-print">
			<div class="col-xs-12">
				<a onclick="window.print()" href="#" type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Cetak</a>
				<a style="margin-right: 1em" href="<?php echo base_url('laporan/riwayat_pembelian/') ?>"  class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
			</div>
		</div>
	</section>