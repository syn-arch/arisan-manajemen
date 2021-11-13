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
                <table class="table">
                    <?php $pengeluaran = $this->db->get_where('biaya', ['DATE(tgl)' => date('Y-m-d'), 'status' => 'PENGELUARAN'])->result_array(); ?>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Biaya</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pengeluaran as $index => $row): ?>
                            <tr>
                                <td><?php echo $index +=1 ?></td>
                                <td><?php echo $row['keterangan_biaya'] ?></td>
                                <td><?php echo "Rp. " . number_format($row['total_bayar']) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>      
                <a href="<?php echo base_url('laporan/thermal_pengeluaran') ?>" class="btn btn-primary btn-block">CETAK</a>
            </div>
        </div>
    </div>
</body>
</html>
