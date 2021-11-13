<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $judul ?></title>
    <meta http-equiv="cache-control" content="max-age=0"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Penjualan</h3>
                <?php 
                $this->db->select_sum('total_bayar', 'total');
                $this->db->where('piutang', 0);
                $this->db->where('status !=', 'Hold');
                $this->db->where('DATE(penjualan.tgl)', date('Y-m-d'));
                $penjualan = $this->db->get('penjualan')->row_array()['total'];
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Penjualan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Penjualan</td>
                            <td><?php echo "Rp. " . number_format($penjualan) ?></td>
                        </tr>
                    </tbody>
                </table>      
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Transaksi Biaya</h3>
                <table class="table">
                    <?php $pemasukan = $this->db->get_where('biaya', ['DATE(tgl)' => date('Y-m-d'), 'status' => 'PEMASUKAN'])->result_array(); ?>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Biaya</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pemasukan as $index => $row): ?>
                            <tr>
                                <td><?php echo $index +=1 ?></td>
                                <td><?php echo $row['keterangan_biaya'] ?></td>
                                <td><?php echo "Rp. " . number_format($row['total_bayar']) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>      
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Piutang Pelanggan</h3>
                <table class="table">
                    <?php 
                    $this->db->where('DATE(pembayaran.tgl)', date('Y-m-d'));
                    $this->db->where('piutang', 1);
                    $this->db->join('penjualan', 'faktur_penjualan');
                    $this->db->where('status !=', 'Hold');
                    $piutang = $this->db->get('pembayaran')->result_array();
                    ?>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($piutang as $index => $row): ?>
                            <tr>
                                <td><?php echo $index +=1 ?></td>
                                <td><?php echo $row['pelanggan_umum'] ?></td>
                                <td><?php echo "Rp. " . number_format($row['nominal']) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>      
                <a href="<?php echo base_url('laporan/thermal_pemasukan') ?>" class="btn btn-primary btn-block">CETAK</a>
            </div>
        </div>
    </div>
</body>
</html>
