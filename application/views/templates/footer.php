</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
	<strong>Copyright &copy; 2020 <a href="#">E-POS</a>.</strong> All rights reserved.
</footer>

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('vendor/lte/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('vendor/lte/') ?>dist/js/adminlte.min.js"></script>
<!-- DataTables -->

<!-- ChartJS -->
<script src="<?php echo base_url('vendor/lte/') ?>bower_components/chart.js/Chart.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url('vendor/lte/') ?>bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- custom js -->
<script src="<?php echo base_url('assets/js/mousetrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/script.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bulk_delete.js') ?>"></script>
<script src="<?php echo base_url('assets/js/cetak_label.js') ?>"></script>
<script src="<?php echo base_url('assets/js/penyesuaian_stok.js') ?>"></script>
<script src="<?php echo base_url('assets/js/transaksi_biaya.js') ?>"></script>
<script src="<?php echo base_url('assets/js/service.js') ?>"></script>

<?php if ($judul == "Tambah Stok Opname" || $judul == "Ubah Stok Opname"): ?>
	<script src="<?php echo base_url('assets/js/stok_opname.js') ?>"></script>
<?php endif ?>

<?php if ($judul == 'Sinkronisasi Database'): ?>
	<script src="<?php echo base_url('assets/js/sinkronisasi_db.js') ?>"></script>
<?php endif ?>


<?php if ($judul == "Dashboard"): ?>
	<script src="<?php echo base_url('assets/js/chart.js') ?>"></script>
<?php endif ?>

<!-- sweetalert -->
<script src="<?php echo base_url('vendor/sweetalert/sweetalert.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/alert.js') ?>"></script>

<!-- datatables -->
<script src="<?php echo base_url('assets/js/datatable/petugas.js') ?>"></script>
<script src="<?php echo base_url('assets/js/datatable/outlet.js') ?>"></script>
<script src="<?php echo base_url('assets/js/datatable/kategori.js') ?>"></script>
<script src="<?php echo base_url('assets/js/datatable/kelompok.js') ?>"></script>
<script src="<?php echo base_url('assets/js/datatable/jadwal_kocokan.js') ?>"></script>
<script src="<?php echo base_url('assets/js/datatable/supplier.js') ?>"></script>
<script src="<?php echo base_url('assets/js/datatable/karyawan.js') ?>"></script>
<script src="<?php echo base_url('assets/js/datatable/agen.js') ?>"></script>
<script src="<?php echo base_url('assets/js/datatable/pelanggan.js') ?>"></script>
<script src="<?php echo base_url('assets/js/datatable/barang.js') ?>"></script>
<script src="<?php echo base_url('assets/js/datatable/stok.js') ?>"></script>
<?php if ($judul == "Riwayat Penjualan"): ?>
<script src="<?php echo base_url('assets/js/datatable/riwayat_penjualan.js') ?>"></script>
<?php endif ?>
<script src="<?php echo base_url('assets/js/datatable/riwayat_pembelian.js') ?>"></script>
<script src="<?php echo base_url('assets/js/datatable/riwayat_pengembalian.js') ?>"></script>
<script src="<?php echo base_url('assets/js/datatable/dashboard.js') ?>"></script>
<script src="<?php echo base_url('assets/js/datatable/pulsa.js') ?>"></script>
<script src="<?php echo base_url('assets/js/datatable/biaya.js') ?>"></script>
<script src="<?php echo base_url('assets/js/datatable/service.js') ?>"></script>

<?php if ($judul == 'Stok Barang'): ?>
	<script src="<?php echo base_url('assets/js/datatable/stok_barang.js') ?>"></script>
<?php endif ?>

<?php if ($judul == "Penjualan" || $judul == "Ubah Penjualan"): ?>
	<!-- penjualan -->
	<script src="<?php echo base_url('assets/js/penjualan.js') ?>"></script>
<?php endif ?>

<?php if ($judul == "Pembelian" || $judul == "Ubah Pembelian"): ?>
	<!-- pembelian -->
	<script src="<?php echo base_url('assets/js/pembelian.js') ?>"></script>
<?php endif ?>

<?php if ($judul == "Pengembalian"): ?>
	<!-- pengembalian -->
	<script src="<?php echo base_url('assets/js/pengembalian.js') ?>"></script>
<?php endif ?>

<!-- prompt logout -->
<script src="<?php echo base_url('assets/js/logout.js') ?>"></script>
</body>
</html>