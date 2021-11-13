<div class="box box-danger">
	<div class="box-header with-border">
		<div class="pull-left">
			<h4 class="box-title"><?php echo $judul ?></h4>
		</div>
		<div class="pull-right">
			<?php if ($this->input->get('dari') && $this->input->get('sampai')): ?>
				<a href="<?php echo base_url('laporan/export_pembelian/' . $this->input->get('dari') . '/' . $this->input->get('sampai')) ?>" class="btn btn-success"><i class="fa fa-sign-in"></i> Export Excel</a>
				<?php else: ?>
					<a href="<?php echo base_url('laporan/export_pembelian') ?>" class="btn btn-success"><i class="fa fa-sign-in"></i> Export Excel</a>
				<?php endif ?>
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
									<th>Kode</th>
									<th>Nama Barang</th>
									<th>Supplier</th>
									<th>Qty</th>
									<th>Harga Beli</th>
									<th>Harga Jual 1</th>
									<th>Harga Jual 2</th>
									<th>Harga Jual 3</th>
									<th>Harga Jual 4</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>

								<?php $no=1; foreach ($laporan as $row): ?>
								<tr>
									<td><?= $no++ ?></td>
									<td><?= $row['id_barang'] ?></td>
									<td><?= $row['nama_barang'] ?></td>
									<td><?= $row['nama_supplier'] ?></td>
									<td><?= $row['barang_terbeli'] ?></td>
									<td><?= "Rp. " . number_format($row['harga_pokok']) ?></td>
									<td><?= "Rp. " . number_format($row['golongan_1']) ?></td>
									<td><?= "Rp. " . number_format($row['golongan_2']) ?></td>
									<td><?= "Rp. " . number_format($row['golongan_3']) ?></td>
									<td><?= "Rp. " . number_format($row['golongan_4']) ?></td>
									<td><?= "Rp. " . number_format($row['total']) ?></td>
								</tr>
							<?php endforeach ?>

						</tbody>
						<tfoot>
							<tr>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th>Total Pembelian</th>
								<th><?= "Rp. " . number_format($total_pembelian) ?></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>