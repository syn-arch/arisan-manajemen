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
    <style type="text/css" media="all">
        @font-face {
            font-family: dot-metrix;
            src: url(<?php echo base_url('assets/font/dot.TTF') ?>);
        }
        *{
            font-size: 12px;
            font-family: dot-metrix;
        }
        tr > td{
            text-align: right;
        }
        tr > td:nth-child(1) {
            text-align: left;
        }
        body { 
            color: #000; 
        }
        #wrapper { 
            max-width: 100%; margin: 0 auto; padding-top: 20px; 
        }
        .btn { 
            margin-bottom: 5px; 
        }
        .table { 
            border-radius: 3px; 
        }
        .table th { 
            background: #f5f5f5; 
        }
        h3 { 
            margin: 5px 0; 
        }
        tfoot tr th:first-child { 
            text-align: right; 
        }
        
        @media print {
            * {
                font-family: dot-metrix;
            }
            .no-print { 
                display: none; 
            }
            #wrapper { 
              width: 100%; min-width: 250px; margin: 0 auto; 
          }
          #receiptData { 
             width: 100%; min-width: 250px; margin: 0 auto; 
         }

     }
 </style>
</head>
<body onload="cetak()">
    <div id="wrapper">
        <div id="receiptData" style="width: 580px; min-width: 250px; margin: 0 auto;">
            <div class="no-print">
            </div>
            <div id="receipt-data">
                <div>
                    <div>
                        <p style="text-align:center;">
                            <strong style="font-size: 20px"><?php echo $outlet['nama_outlet'] ?></strong><br>
                        </p>
                    </div>
                   <div class="row">
                    <div class="col-xs-6">
                     <div class="row">
                        <div class="col-xs-5">
                            <strong>Faktur</strong>
                        </div>
                        <div class="col-xs-6">
                           : <?php echo $penjualan['faktur_penjualan'] ?>
                       </div>
                   </div>
                   <div class="row">
                    <div class="col-xs-5">
                        <strong>Tanggal</strong>
                    </div>
                    <div class="col-xs-6">
                        : <?php echo $penjualan['tgl'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-5">
                        <strong>Kasir</strong>
                    </div>
                    <div class="col-xs-6">
                       : <?php echo $penjualan['nama_karyawan'] ?>
                   </div>
               </div>
               <?php if ($penjualan['jenis'] == 'member'): ?>
                <div class="row">
                    <div class="col-xs-5">
                        <strong>Nama</strong>
                    </div>
                    <div class="col-xs-6">
                        : <?php echo $penjualan['nama_pelanggan'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-5">
                        <strong>Alamat</strong>
                    </div>
                    <div class="col-xs-6">
                        : <?php echo $penjualan['alamat'] ?>
                    </div>
                </div>
                <?php else: ?>
                    <?php if ($penjualan['nama_pengiriman'] != '' || $penjualan['alamat_pengiriman'] != ''): ?>
                       <div class="row">
                        <div class="col-xs-5">
                            <strong>Nama</strong>
                        </div>
                        <div class="col-xs-6">
                            : <?php echo $penjualan['nama_pengiriman'] ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5">
                            <strong>Alamat</strong>
                        </div>
                        <div class="col-xs-6">
                            : <?php echo $penjualan['alamat_pengiriman'] ?>
                        </div>
                    </div>
                <?php endif ?>
            <?php endif ?></div>
                    <div class="col-xs-6">
                        <div class="row">
                            <div class="col-xs-5">
                                </div>
                                <div class="col-xs-6">
                                <?php echo $outlet['alamat'] ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-5">
                                </div>
                                <div class="col-xs-6">
                                <?php echo $outlet['telepon'] ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-5">
                                </div>
                                <div class="col-xs-6">
                                <?php echo $outlet['email'] ?>
                            </div>
                        </div>
                    </div>
                   </div>
            <div style="clear:both;margin-top: 10px"></div>
            <table style="width: 100%">
                <thead style="border: 0.2px solid black;">
                    <tr>
                        <th class="text-left" style="width: 40%; border-left:0.2px solid black;padding: 5px">Barang</th>
                        <th class="text-right" style="width: 20%; border-left:0.2px solid black;padding: 5px">Harga</th>
                        <th class="text-right" style="width: 10%; border-left:0.2px solid black;padding: 5px">Diskon</th>
                        <th class="text-right" style="width: 10%; border-left:0.2px solid black;padding: 5px">Qty</th>
                        <th class="text-right" style="width: 20%;border-left:0.2px solid black;border-right: 0.2px solid black;padding: 5px">Subtotal</th>
                    </tr>
                </thead>
                <tbody style="border: 0.2px solid black;">
                    <?php 
                    $no = 1;
                    $this->db->select('*');
                    $this->db->join('barang', 'id_barang');
                    $barang =  $this->db->get_where('detail_penjualan', ['faktur_penjualan' => $penjualan['faktur_penjualan']])->result_array();
                    foreach ($barang as $row) : ?>
                        <tr>
                            <td style="border-left:0.2px solid black;padding: 5px;"><?php echo $row['nama_pendek'] ?></td>
                            <?php 
                            $this->db->select($row['type_golongan'] . ' AS harga_jual');
                            $harga_jual = $this->db->get_where('barang', ['id_barang' => $row['id_barang']])->row()->harga_jual;
                            ?>
                            <td style="border-left:0.2px solid black;padding: 5px;"><?php echo "Rp. " . number_format($harga_jual) ?></td>
                            <td style="border-left:0.2px solid black;padding: 5px;"><?php echo $row['diskon'] ?></td>
                            <td style="border-left:0.2px solid black;padding: 5px;"><?php echo $row['jumlah'] ?></td>
                            <td style="border-left:0.2px solid black;border-right: 0.2px solid black;padding: 5px"><?php echo "Rp. " . number_format($row['total_harga']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4"><br>Total Belanja :</th>
                        <td colspan="3"><br><?php echo "Rp. " . number_format($total_belanja) ?></td>
                    </tr>
                    <tr>
                        <th colspan="4">Diskon :</th>
                        <td colspan="3"><?php echo $penjualan['diskon'] . ' %' ?></td>
                    </tr>   
                    <tr>
                        <th colspan="4">Potongan :</th>
                        <td colspan="3"><?php echo "Rp. " . number_format($penjualan['potongan']) ?></td>
                    </tr>
                    <tr>
                        <th colspan="4">Total Bayar :</th>
                        <td colspan="3"><?php echo "Rp. " . number_format($penjualan['total_bayar']) ?></td>
                    </tr>
                    <tr>
                        <th colspan="4">Cash :</th>
                        <td colspan="3"><?php echo "Rp. " . number_format($total_bayar) ?></td>
                    </tr>   
                    <?php if ($total_bayar >= $penjualan['total_bayar']): ?>
                        <tr>
                            <th colspan="4">Kembalian :</th>
                            <td colspan="3"><?php echo "Rp. " . number_format($total_bayar - $penjualan['total_bayar']) ?></td>
                        </tr>
                        <?php else : ?>
                          <tr>
                            <th colspan="4">Harus Dibayar :</th>
                            <td colspan="3"><?php echo "Rp. " . number_format($penjualan['total_bayar'] - $total_bayar) ?></td>
                        </tr>
                    <?php endif; ?>          
                </tfoot>
            </table>
            <div style="margin-top:20px; border: 0.2px solid black; padding: 10px">
                <p class="text-center">** TERIMA KASIH **</p>
                <div style="text-align: center;"><?php echo $pengaturan['keterangan_invoice'] ?></div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
<script>
    function cetak() {
        window.print();
		setTimeout("window.close();", 1000);
    }
</script>
</html>
