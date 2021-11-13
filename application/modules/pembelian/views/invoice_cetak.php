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
        body { color: #000; }
        #wrapper { max-width: 520px; margin: 0 auto; padding-top: 20px; }
        .btn { margin-bottom: 5px; }
        .table { border-radius: 3px; }
        .table th { background: #f5f5f5; }
        .table th, .table td { vertical-align: middle !important; }
        h3 { margin: 5px 0; }

        @media print {
            .no-print { display: none; }
            #wrapper { max-width: 720px; width: 100%; min-width: 250px; margin: 0 auto; }
        }
        tfoot tr th:first-child { text-align: right; }
    </style>
</head>
<body>
    <div id="wrapper">
        <div id="receiptData" style="width: auto; max-width: 580px; min-width: 250px; margin: 0 auto;">
            <div class="no-print">
            </div>
            <div id="receipt-data">
             <div>
                <div>
                    <p style="text-align:center;">
                        <strong><?php echo $outlet['nama_outlet'] ?></strong><br>
                        <?php echo $outlet['alamat'] ?><br>
                        <?php echo $outlet['email'] ?><br>
                        <?php echo $outlet['telepon'] ?>
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <strong>Faktur</strong>
                    </div>
                    <div class="col-md-5">
                        <?php echo $pembelian['faktur_pembelian'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <strong>Tanggal</strong>
                    </div>
                    <div class="col-md-5">
                        <?php echo date('d-m-Y', strtotime($pembelian['tgl'])) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <strong>Petugas</strong>
                </div>
                <div class="col-md-5">
                    <?php echo $pembelian['nama_petugas'] ?>
                </div>
            </div>
            <div style="clear:both;"></div>
            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10%; border-bottom: 2px solid #ddd;">No</th>
                        <th class="text-center" style="width: 25%; border-bottom: 2px solid #ddd;">Barang</th>
                        <th class="text-center" style="width: 20%; border-bottom: 2px solid #ddd;">Harga</th>
                        <th class="text-center" style="width: 10%; border-bottom: 2px solid #ddd;">Qty</th>
                        <th class="text-center" style="width: 25%; border-bottom: 2px solid #ddd;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $this->db->join('barang', 'id_barang');
                    $barang =  $this->db->get_where('detail_pembelian', ['faktur_pembelian' => $pembelian['faktur_pembelian']])->result_array();
                    foreach ($barang as $row) : ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['nama_barang'] ?></td>
                            <td><?php echo "Rp. " . number_format($row['harga_pokok']) ?></td>
                            <td><?php echo $row['jumlah'] ?></td>
                            <td><?php echo "Rp. " . number_format($row['harga_pokok'] * $row['jumlah']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total Item</th>
                        <th colspan="3" class="text-right"><?php echo "Rp. " . number_format($pembelian['total_item']) ?></th>
                    </tr>
                    <tr>
                        <th colspan="3">Total</th>
                        <th colspan="3" class="text-right"><?php echo "Rp. " . number_format($pembelian['total_bayar']) ?></th>
                    </tr>
                    <tr>
                        <th colspan="3">Cash</th>
                        <th colspan="3" class="text-right"><?php echo "Rp. " . number_format($pembelian['cash']) ?></th>
                    </tr>                                             
                    <tr>
                        <th colspan="3">Kembalian</th>
                        <th colspan="3" class="text-right"><?php echo "Rp. " . number_format($pembelian['cash'] - $pembelian['total_bayar']) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div style="clear:both;"></div>
    </div>

    <!-- start -->
    <div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
        <hr>
        <div class="row">
            <span class="col-xs-12">
                <button onclick="window.print();" class="btn btn-block btn-primary">Cetak</button>
            </span>
            <span class="col-xs-12">
                <a class="btn btn-block btn-success" href="<?php echo base_url('pembelian') ?>">Kembali Ke pembelian</a>
            </span>
        </div>
    </div>
    <!-- end -->
</div>
</div>
</body>
</html>
