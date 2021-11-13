<div class="box box-danger">
	<div class="box-header with-border">
		<div class="pull-left">
			<h4 class="box-title"><?php echo $judul ?> Hari Ini</h4>
		</div>
		<div class="pull-right">
			<a href="<?php echo base_url('laporan/export_register') ?>" class="btn btn-success"><i class="fa fa-sign-in"></i> Export Excel</a>
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
								<th>Petugas</th>
								<th>Outlet</th>
								<th>Saldo Awal</th>
								<th>Saldo Akhir</th>
								<th>Mulai</th>
								<th>Berakhir</th>
								<th>Status</th>
								<th><i class="fa fa-gears"></i></th>
							</tr>
						</thead>
						<tbody>

							<?php $no=1; foreach ($laporan as $row): ?>
							<?php 
							if ($row['berakhir'] == '0000-00-00 00:00:00') {
								$berakhir = '';
							}else{
								$berakhir = date('d-m-Y H:i:s', strtotime($row['berakhir']));
							}
							?>
							<tr>
								<td><?= $no++ ?></td>
								<td><?= $row['nama_petugas'] ?></td>
								<td><?= $row['nama_outlet'] ?></td>
								<td><?= "Rp. " . number_format($row['uang_awal']) ?></td>
								<td><?= "Rp. " . number_format($row['total_uang']) ?></td>
								<td><?= date('d-m-Y H:i:s', strtotime($row['mulai'])) ?></td>
								<td><?php echo $berakhir ?></td>
								<td><?php echo $row['status'] ?></td>
								<td>
									<a target="_blank" href="<?php echo base_url('laporan/cetak_register/') . $row['id_register'] ?>" class="btn btn-info"><i class="fa fa-print"></i></a>
									<a data-href="<?php echo base_url('laporan/hapus_register/') . $row['id_register'] ?>" class="btn btn-danger hapus_register"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
						<?php endforeach ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>