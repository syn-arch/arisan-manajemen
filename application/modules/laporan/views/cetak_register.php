<?php 
$pengaturan = $this->db->get('pengaturan')->row_array(); 

if ($id_outlet = $this->session->userdata('id_outlet')) {
    $outlet = $this->db->get_where('outlet', ['id_outlet' => $id_outlet])->row_array();
}else{
    $outlet = $this->db->get('outlet')->row_array();
}


?>
<!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $judul ?></title>
        <meta http-equiv="cache-control" content="max-age=0"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <meta http-equiv="expires" content="0"/>
        <meta http-equiv="pragma" content="no-cache"/>
        <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>dist/css/AdminLTE.min.css">
        <style type="text/css" media="all">
    </style>
</head>
<body>
    <div id="wrapper">
        <div id="receiptData" style="width: auto; max-width: 580px; min-width: 250px; margin: 0 auto;">
            <div class="no-print">
            </div>
            <div id="receipt-data">
                <div>
                    <div style="text-align:center;">
                        <p style="text-align:center;">
                            <strong><?php echo $outlet['nama_outlet'] ?></strong><br>
                            <?php echo $outlet['alamat'] ?><br>
                            <?php echo $outlet['email'] ?><br>
                            <?php echo $outlet['telepon'] ?>
                        </p>
                    </div>
                    <div style="clear:both;"></div>
                    <?php  
                    $this->db->select_sum('total_bayar', 'total');
                    $this->db->where('piutang', 0);
                    $this->db->where('status !=', 'Hold');
                    $this->db->where('DATE(penjualan.tgl)', date('Y-m-d'));
                    $penjualan = $this->db->get('penjualan')->row_array()['total'];

                    $this->db->select_sum('nominal', 'total');
                    $this->db->where('DATE(pembayaran.tgl)', date('Y-m-d'));
                    $this->db->where('piutang', 1);
                    $this->db->join('penjualan', 'faktur_penjualan');
                    $this->db->where('status !=', 'Hold');
                    $piutang = $this->db->get('pembayaran')->row_array()['total'];

                    $this->db->select_sum('total_bayar', 'total');
                    $pemasukan = $this->db->get_where('biaya', ['DATE(tgl)' => date('Y-m-d'), 'status' => 'PEMASUKAN'])->row()->total;

                    $this->db->select_sum('total_bayar', 'total');
                    $pengeluaran = $this->db->get_where('biaya', ['DATE(tgl)' => date('Y-m-d'), 'status' => 'PENGELUARAN'])->row()->total;
                    ?>
                    <table class="table table-condensed">
                        <tr>
                            <th>Nama Petugas</th>
                            <td><?php echo $register['nama_petugas'] ?></td>
                        </tr>
                        <tr>
                            <th>Nama Outlet</th>
                            <td><?php echo $outlet['nama_outlet'] ?></td>
                        </tr>
                        <tr>
                            <th>Mulai</th>
                            <td><?php echo date('d-m-Y H:i:s', strtotime($register['mulai'])) ?></td>
                        </tr>
                        <tr>
                            <th>Berakhir</th>
                            <?php if ($register['berakhir'] == '0000-00-00 00:00:00'): ?>
                                <td></td>
                            <?php else: ?>
                                <td><?php echo date('d-m-Y H:i:s', strtotime($register['berakhir'])) ?></td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>Saldo Awal</th>
                            <td><?php echo "Rp. " . number_format($register['uang_awal']) ?></td>
                        </tr>
                        <?php if ($register['total_uang'] == 0): ?>
                            <tr>
                                <th>Penjualan</th>
                                <td><?php echo "Rp. " . number_format($penjualan) ?></td>
                            </tr>
                            <tr>
                                <th>Pemasukan</th>
                                <td><?php echo "Rp. " . number_format($pemasukan) ?></td>
                            </tr>
                            <tr>
                                <th>Piutang</th>
                                <td><?php echo "Rp. " . number_format($piutang) ?></td>
                            </tr>
                            <tr>
                                <th>Pengeluaran</th>
                                <td><?php echo "Rp. " . number_format($pengeluaran) ?></td>
                            </tr>
                            <tr>
                                <th>Saldo Akhir</th>
                                <?php 
                                $id_petugas = $this->session->userdata('id_petugas');

                                $q1 = "SELECT SUM(total_uang) AS 'total' FROM `register` WHERE DATE(mulai) = DATE(NOW()) AND status = 'close' AND id_petugas = '$id_petugas' ";
                                $total_uang = $this->db->query($q1)->row()->total ?? 0;

                                $q2 = "SELECT SUM(uang_awal) AS 'uang_awal' FROM `register` WHERE DATE(mulai) = DATE(NOW()) AND status = 'close' AND id_petugas = '$id_petugas' ";
                                $uang_awal = $this->db->query($q2)->row()->uang_awal ?? 0;

                                $total_tarik = $total_uang - $uang_awal;
                                ?>
                                <td><?php echo "Rp. " . number_format($register['uang_awal'] + ($penjualan - $total_tarik) + $piutang + $pemasukan - $pengeluaran ) ?></td>
                            </tr>
                        <?php else: ?>
                         <tr>
                            <th>Penjualan</th>
                            <td><?php echo "Rp. " . number_format($register['penjualan']) ?></td>
                        </tr>
                        <tr>
                            <th>Pemasukan</th>
                            <td><?php echo "Rp. " . number_format($register['pemasukan']) ?></td>
                        </tr>
                        <tr>
                            <th>Piutang</th>
                            <td><?php echo "Rp. " . number_format($register['piutang']) ?></td>
                        </tr>
                        <tr>
                            <th>Pengeluaran</th>
                            <td><?php echo "Rp. " . number_format($register['pengeluaran']) ?></td>
                        </tr>
                        <tr>
                            <th>Saldo Akhir</th>
                            <td><?php echo "Rp. " . number_format($register['total_uang']) ?></td>
                        </tr>
                    <?php endif ?>
                </table>
            </div>
        </div>

        <!-- start -->
        <div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
            <hr>
                <span class="pull-right col-xs-12">
            <?php if ($this->uri->segment(3)): ?>
                    <a href="<?php echo base_url('laporan/cetak_thermal_register/') . $register['id_register'] ?>" class="btn btn-info btn-block">Cetak (Thermal)</a>
            <?php else : ?>
                    <a href="<?php echo base_url('laporan/cetak_thermal_register') ?>" class="btn btn-info btn-block">Cetak (Thermal)</a>
                    <a href="<?php echo base_url('laporan/cetak_thermal_pemasukan') ?>" class="btn btn-info btn-block">Cetak Pemasukan (Thermal)</a>
                    <a href="<?php echo base_url('laporan/cetak_thermal_pengeluaran') ?>" class="btn btn-info btn-block">Cetak Pengeluaran (Thermal)</a>
                <?php endif ?>
                <a class="btn btn-block btn-danger" href="<?php echo base_url('logout') ?>">Logout</a>
                <a class="btn btn-block btn-warning" href="<?php echo base_url('penjualan') ?>">Kembali Ke Penjualan</a>
                <a class="btn btn-block btn-success" href="<?php echo base_url('laporan/register') ?>">Kembali Ke Laporan</a>
            </span>
        </div>
    </div>
</div>
</body>
</html>
