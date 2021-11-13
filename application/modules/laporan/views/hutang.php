<div class="box box-danger">
<div class="box box-danger">
	<div class="box-header with-border">
		<div class="pull-left">
			<h4 class="box-title"><?php echo $judul ?></h4>
		</div>
		<div class="pull-right">
			<a href="<?php echo base_url('laporan/export_hutang') ?>" class="btn btn-success"><i class="fa fa-sign-in"></i> Export Excel</a>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive">
					<table class="table datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Tanggal</th>
								<th>Faktur</th>
								<th>Nama Supplier</th>
								<th>Jatuh Tempo</th>
								<th>Jumlah Hutang</th>
								<th>Telah Dibayar</th>
								<th>Sisa Hutang</th>
								<th>Status</th>
								<th><i class="fa fa-cogs"></i></th>
							</tr>
						</thead>
						<tbody>
							
							<?php $i = 1; ?>
							<?php foreach ($laporan as $row): ?>
								<tr>
									<td><?php echo $i++ ?></td>
									<td><?php echo $row['tgl'] ?></td>
									<td><?php echo $row['faktur_pembelian'] ?></td>
									<td><?php echo $row['nama_supplier'] ?></td>
									<td><?php echo $row['tgl_jatuh_tempo'] ?></td>
									<td><?php echo 'Rp. ' . number_format($row['jumlah_hutang']) ?></td>
									<td><?php echo 'Rp. ' . number_format($row['telah_dibayar']) ?></td>
									<td><?php echo 'Rp. ' . number_format($row['jumlah_hutang'] - $row['telah_dibayar']) ?></td>
									<td>
										<?php if (strtotime(date('Y-m-d')) > strtotime($row['tgl_jatuh_tempo']) ): ?>
											<button class="btn btn-danger">TERLEWAT</button>
										<?php else : ?>
											<button class="btn btn-success">BELUM TERLEWAT</button>
										<?php endif ?>
									</td>
									<td>
										<a href="<?php echo base_url('pembelian/invoice_cetak/') . $row['faktur_pembelian'] ?>" class="btn btn-info"><i class="fa fa-print"></i></a>
										<a href="<?php echo base_url('pembelian/ubah/') . $row['faktur_pembelian'] ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
										<a href="<?php echo base_url('pembelian/pembayaran/') . $row['faktur_pembelian'] ?>" class="btn btn-success"><i class="fa fa-list"></i></a>
										<a href="<?php echo base_url('pembelian/tambah_pembayaran/') . $row['faktur_pembelian'] ?>" class="btn btn-primary"><i class="fa fa-dollar"></i></a>
									</td>
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
								<th><?= "Rp. " . number_format($total_hutang) ?></th>
								<th><?= "Rp. " . number_format($telah_dibayar) ?></th>
								<th><?= "Rp. " . number_format($total_hutang - $telah_dibayar) ?></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>