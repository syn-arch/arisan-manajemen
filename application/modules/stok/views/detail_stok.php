<section class="invoice">
	<!-- title row -->
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-shopping-cart"></i> E-POS - Faktur Penyesuaian Stok
				<small class="pull-right">Tanggal: <?php echo date('d-m-Y', strtotime($stok['tgl'])) ?></small>
			</h2>
		</div>
		<!-- /.col -->
	</div>
	<!-- info row -->
	<div class="row invoice-info">
		<div class="col-sm-4 invoice-col">
			<address>
				Petugas : <?php echo $stok['nama_petugas'] ?><br>
				Dari	: <?php echo $stok['dari'] ?? 'Gudang' ?><br>
				Ke	: <?php echo $stok['ke'] ?><br>
				Keterangan	: <?php echo $stok['keterangan'] ?><br>
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
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					$this->db->join('barang', 'id_barang');
					$barang =  $this->db->get_where('detail_stok', ['id_stok' => $stok['id_stok']])->result_array();
					foreach ($barang as $row) : ?>
						<tr>
							<td><?php echo $no++ ?></td>
							<td><?php echo $row['id_barang'] ?></td>
							<td><?php echo $row['nama_barang'] ?></td>
							<td><?php echo $row['jumlah'] ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			<br>
			<br>
			<div style="width: 100% ; display: flex; justify-content: space-between; padding: 0 60px 0 60px">
				<span class="text-center">
					<p>Pengirim</p>
					<br>
					<br>
					<br>
				</span class="text-center">
				<span>
					<p>Penerima</p>
					<br>
					<br>
					<br>
				</span>
			</div>
		</div>
		<!-- /.col -->
	</div>
	
	<!-- /.row -->
	<!-- this row will not appear when printing -->
	<div class="row no-print">
		<div class="col-xs-12">
			<a href="#" onclick="window.print()" type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Cetak</a>
			<a style="margin-right: 1em" href="<?php echo base_url('stok') ?>"  class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
		</div>
	</div>
</section>