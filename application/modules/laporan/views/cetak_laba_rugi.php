<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="base_url" content="<?php echo base_url() ?>">
  <title><?php echo $judul ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="icon" href="<?php echo base_url('assets/img/favicon.png') ?>" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>dist/css/skins/skin-red.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print()">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="text-center">
          Laporan Laba Rugi <?php echo $this->uri->segment(3) . ' Sampai ' . $this->uri->segment(4) ?>
        </h2>
        <table class="table table-bordered table-striped table-hover">
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
        <h4>Outlet : <?php echo $outlet['nama_outlet'] ?? 'Semua Outlet' ?></h4>
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
  </div>
</body>
</html>