<section class="invoice">
	<!-- title row -->
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-shopping-cart"></i> E-POS - Faktur Penjualan
				<small class="pull-right">Tanggal: <?php echo date('d-m-Y', strtotime($penjualan['tgl'])) ?></small>
			</h2>
		</div>
		<!-- /.col -->
	</div>
	<!-- info row -->
	<div class="row invoice-info">
		<div class="col-sm-4 invoice-col">
			<address>
				<strong>Kasir : <?php echo $penjualan['nama_petugas'] ?></strong><br>
				<strong>Pelanggan : <?php echo $penjualan['nama_pelanggan'] ?></strong><br>
				<strong>Agen : <?php echo $penjualan['nama_agen'] ?></strong><br>
				<?php if ($penjualan['jenis'] == 'member'): ?>
					Alamat	: <?php echo $penjualan['alamat'] ?><br>
					Telepon	:<?php echo $penjualan['telepon'] ?><br>
				<?php else: ?>
					<?php if ($penjualan['nama_pengiriman']  != '' || $penjualan['alamat_pengiriman'] != ''): ?>
						Nama	: <?php echo $penjualan['nama_pengiriman'] ?><br>
						Alamat	:<?php echo $penjualan['alamat_pengiriman'] ?><br>
					<?php endif ?>
				<?php endif ?>
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
						<th>Kode Barang</th>
						<th>Nama Barang</th>
						<th>Harga</th>
						<th>Diskon</th>
						<th>Qty</th>
						<th>Subtotal</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					$this->db->select('*');
					$this->db->join('barang', 'id_barang');
					$barang =  $this->db->get_where('detail_penjualan', ['faktur_penjualan' => $penjualan['faktur_penjualan']])->result_array();
					foreach ($barang as $row) : ?>
						<tr>
							<td><?php echo $no++ ?></td>
							<td><?php echo $row['id_barang'] ?></td>
							<td><?php echo $row['nama_pendek'] ?></td>
							<?php 
							$this->db->select($row['type_golongan'] . ' AS harga_jual');
							$harga_jual = $this->db->get_where('barang', ['id_barang' => $row['id_barang']])->row()->harga_jual;
							?>
							<td><?php echo "Rp. " . number_format($harga_jual) ?></td>
							<td><?php echo $row['diskon'] ?></td>
							<td><?php echo $row['jumlah'] ?></td>
							<td><?php echo "Rp. " . number_format($row['total_harga']) ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
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
							<th>Total Item</th>
							<td><?php echo $penjualan['total_item'] ?></td>
						</tr>
						<tr>
							<th>Total Belanja</th>
							<td><?php echo "Rp. " . number_format($total_belanja) ?></td>
						</tr>
						<tr>
							<th>Diskon</th>
							<td><?php echo $penjualan['diskon'] .' %' ?></td>
						</tr>
						<tr>
							<th>Potongan</th>
							<td><?php echo "Rp. " . number_format($penjualan['potongan']) ?></td>
						</tr>
						<tr>
							<th>Total</th>
							<td><?php echo "Rp. " . number_format($penjualan['total_bayar']) ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->

	<!-- this row will not appear when printing -->
	<div class="row no-print">
		<div class="col-xs-12">
			<a style="margin-right: 1em" href="<?php echo base_url('laporan/riwayat_penjualan') ?>" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
		</div>
	</div>
</section>