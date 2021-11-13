<div class="box box-danger">
	<div class="box-header with-border">
		<div class="pull-left">
			<h4 class="box-title"><?php echo $judul ?></h4>
		</div>
		<div class="pull-right">
			<a href="<?= base_url('laporan/penjualan') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-lg-6">
				<form action="">
					<div class="form-group">
						<label for="">Dari Tanggal</label>
						<input type="date" name="dari" id="dari" class="form-control">
					</div>
					<div class="form-group">
						<label for="">Sampai Tanggal</label>
						<input type="date" name="sampai" id="dari" class="form-control">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-danger btn-block">Submit</button>
					</div>
				</form>
			</div>
		</div>
		<br>
		<br>
		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive">
					<table class="table datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Kode Kasir</th>
								<th>Nama Kasir</th>
								<th>Penjualan</th>
								<th>Pendapatan</th>
							</tr>
						</thead>
						<tbody>

							<?php $no=1; foreach ($laporan as $row): ?>
							<tr>
								<td><?= $no++ ?></td>
								<td><?= $row['id_petugas'] ?></td>
								<td><?= $row['nama_petugas'] ?></td>
								<td><?= $row['transaksi'] ?></td>
								<td><?= "Rp. " . number_format($row['pendapatan']) ?></td>
							</tr>
						<?php endforeach ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>