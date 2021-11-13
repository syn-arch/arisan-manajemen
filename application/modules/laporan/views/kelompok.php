<div class="box box-danger">
	<div class="box-header with-border">
		<div class="pull-left">
			<h4 class="box-title"><?php echo $judul ?></h4>
		</div>
	</div>
	<div class="box-body">
		<?php if (!$this->input->get('id_agen')): ?>			
			<div class="row">
				<div class="col-lg-6">
					<form action="">
						<div class="form-group <?php if(form_error('id_outlet')) echo 'has-error'?>">
							<label for="id_agen">Agen</label>
							<select name="id_agen" id="id_agen" class="form-control select2">
								<?php foreach ($agen as $row): ?>
									<option <?php echo $row['id_agen'] == $this->input->get('id_agen') ? 'selected' : '' ?> value="<?php echo $row['id_agen'] ?>"><?php echo $row['nama_agen'] ?></option>
								<?php endforeach ?>
							</select>
							<?php echo form_error('id_agen', '<small style="color:red">','</small>') ?>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-danger btn-block">Submit</button>
						</div>
					</form>
				</div>
			</div>
			<br>
			<br>
		<?php endif ?>

		<?php if ($this->input->get('id_agen')): ?>	
			<div class="row">
				<div class="col-md-6">
					<table class="table">
						<tr>
							<th>Nama Agen</th>
							<td><?php echo $kelompok[0]['nama_agen'] ?></td>
						</tr>
						<tr>
							<th>Alamat</th>
							<td><?php echo $kelompok[0]['alamat'] ?></td>
						</tr>
						<tr>
							<th>Telepon</th>
							<td><?php echo $kelompok[0]['telepon'] ?></td>
						</tr>
						<tr>
							<th>Kelompok</th>
							<td><?php echo $kelompok[0]['nama_kelompok'] ?></td>
						</tr>
						<tr>
							<th>Nominal Kocokan</th>
							<td><?php echo $kelompok[0]['nominal_kocokan'] ?></td>
						</tr>
						<tr>
							<th>Periode Arisan</th>
							<td><?php echo $kelompok[0]['periode_arisan'] ?></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="table datatable table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Nama Barang</th>
								<th>Harga/Hari</th>
								<th>Tgl Terima Kocokan</th>
								<th>Keterangan</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($kelompok as $index => $row): ?>
								<tr>
									<td><?php echo $index += 1; ?></td>
									<td><?php echo $row['id_barang'] ?></td>
									<td><?php echo $row['nama_barang'] ?></td>
									<td><?php echo number_format($row['angsuran']) ?></td>
									<td><?php echo $row['tgl_terima_kocokan'] ?></td>
									<td><?php echo $row['keterangan'] ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>