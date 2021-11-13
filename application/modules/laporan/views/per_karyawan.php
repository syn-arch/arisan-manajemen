<div class="box box-danger">
	<div class="box-header with-border no-print">
		<div class="pull-left">
			<h4 class="box-title"><?php echo $judul ?></h4>
		</div>
		<div class="pull-right">
			<?php if ($this->input->get('dari')): ?>
				<a onclick="window.print()" href="#" class="btn btn-success"><i class="fa fa-print"></i> Cetak</a>
			<?php endif ?>
			<a href="<?= base_url('laporan/penjualan') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
		</div>
	</div>
	<div class="box-body">
		<div class="row no-print">
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
		<?php if ($this->input->get('dari')): ?>			
			<h2 class="text-center mb-4">Laporan <?php echo $this->input->get('dari') ?> Sampai <?php echo $this->input->get('sampai') ?></h2>
			<br>
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table datatable">
							<thead>
								<tr>
									<th>#</th>
									<th>Kode Karyawan</th>
									<th>Nama Karyawan</th>
									<th>Penjualan</th>
									<th>Pendapatan</th>
								</tr>
							</thead>
							<tbody>

								<?php $no=1; foreach ($laporan as $row): ?>
								<tr>
									<td><?= $no++ ?></td>
									<td><?= $row['id_karyawan'] ?></td>
									<td><?= $row['nama_karyawan'] ?></td>
									<td><?= $row['transaksi'] ?></td>
									<td><?= "Rp. " . number_format($row['pendapatan']) ?></td>
								</tr>
							<?php endforeach ?>

						</tbody>
					</table>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>