<div class="box box-danger">
	<div class="box-header with-border">
		<div class="pull-left">
			<h4 class="box-title"><?php echo $judul ?></h4>
		</div>
		<div class="pull-right">
			<?php if ($dari = $this->input->get('dari') && $sampai = $this->input->get('sampai')): ?>
				<a href="<?= base_url('laporan/cetak_laba_rugi/' . $this->input->get('dari') . '/' . $sampai . '/' . $this->input->get('id_outlet')) ?>" class="btn btn-success"><i class="fa fa-print"></i> Cetak</a>
			<?php endif ?>
			<a href="<?= base_url('laporan/penjualan') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-lg-6">
				<form action="">
					<div class="form-group">
						<label for="">Dari Tanggal</label>
						<input type="date" name="dari" id="dari" class="form-control" value="<?php echo $this->input->get('dari') ?>">
					</div>
					<div class="form-group">
						<label for="">Sampai Tanggal</label>
						<input type="date" name="sampai" id="dari" class="form-control" value="<?php echo $this->input->get('sampai') ?>">
					</div>
					<div class="form-group <?php if(form_error('id_outlet')) echo 'has-error'?>">
						<label for="id_outlet">Outlet</label>
						<select name="id_outlet" id="id_outlet" class="form-control">
							<option value="">Semua Outlet</option>
							<?php foreach ($outlet as $row): ?>
								<option <?php echo $row['id_outlet'] == $this->input->get('id_outlet') ? 'selected' : '' ?> value="<?php echo $row['id_outlet'] ?>"><?php echo $row['nama_outlet'] ?></option>
							<?php endforeach ?>
						</select>
						<?php echo form_error('id_outlet', '<small style="color:red">','</small>') ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-danger btn-block">Submit</button>
					</div>
				</form>
			</div>
		</div>
		<br>
		<br>
		<?php if ($this->input->get('dari')): ?>	
			<div class="row">
				<div class="col-md-12">
					<table class="table datatable table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Tanggal</th>
								<th>Pendapatan</th>
								<th>Pemasukan</th>
								<th>Pengeluaran</th>
								<th>Laba Rugi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($laba_rugi as $index => $row): ?>
								<!-- pendapatan_bersih + pemasukan - pengeluaran -->
								<?php 
								$pendapatan_bersih_a = $this->laporan_model->get_pendapatan($row['tanggal'], $row['tanggal'], 'OTL00001', true);
								$pemasukan_a = $this->laporan_model->get_pemasukan($row['tanggal'], $row['tanggal'], 'OTL00001');
								$pengeluaran_a = $this->laporan_model->get_pengeluaran($row['tanggal'], $row['tanggal'], 'OTL00001');
								$total = $pendapatan_bersih_a + $pemasukan_a - $pengeluaran_a;
								$bersih = $this->laporan_model->get_pendapatan_bersih($row['tanggal'], $row['tanggal'], 'OTL00001');
								?>
								<tr>
									<td><?php echo $index += 1; ?></td>
									<td><?php echo $row['tanggal'] ?></td>
									<td><?php echo number_format($pendapatan_bersih_a) ?></td>
									<td><?php echo number_format($pemasukan_a) ?></td>
									<td><?php echo number_format($pengeluaran_a) ?></td>
									<td><?php echo number_format($bersih) ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-bordere">
							<tr>
								<th width="40%"><h3>Penjualan</h3></th>
							</tr>
							<tr>
								<th width="70%">Penjualan Kotor</th>
								<td><?php echo "Rp. " . number_format($pendapatan) ?></td>
							</tr>
							<tr>
								<th>Potongan Penjualan (Diskon)</th>
								<td><?php echo "Rp. " . number_format($potongan) ?></td>
							</tr>
							<tr>
								<th width="70%">Penjualan Bersih</th>
								<td><?php echo "Rp. " . number_format($pendapatan_bersih) ?></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th width="70%"><h3>Laba Penjualan</h3></th>
								<td><h3><?php echo "Rp. " . number_format($harga_pokok) ?></h3></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th><h3>Macam-macam pendapatan</h3></th>
								<td></td>
							</tr>
							<?php foreach ($detail_pemasukan as $row): ?>
							<tr>
								<td><?php echo $row['keterangan_biaya'] ?></td>
								<td><?php echo "Rp. " . number_format($row['total_bayar']) ?></td>
							</tr>
							<?php endforeach ?>
							<tr>
								<th>Total macam-macam pendapatan</th>
								<td><?php echo "Rp. " . number_format($pemasukan) ?></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th><h3>Macam-macam pengeluaran</h3></th>
								<td></td>
							</tr>
							<?php foreach ($detail_pengeluaran as $row): ?>
							<tr>
								<td><?php echo $row['keterangan_biaya'] ?></td>
								<td><?php echo "Rp. " . number_format($row['total_bayar']) ?></td>
							</tr>
							<?php endforeach ?>
							<tr>
								<th>Total macam-macam pengeluaran</th>
								<td><?php echo "Rp. " . number_format($pengeluaran) ?></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th><h3>Total Keuangan</h3></th>
								<td><h3><?php echo "Rp. " . number_format( $pendapatan_bersih + $pemasukan - $pengeluaran) ?></h3></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>