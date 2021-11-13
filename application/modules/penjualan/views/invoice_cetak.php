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
            font-family: 'dot-metrix';
            src: url(<?php echo base_url('assets/font/dot.TTF') ?>);
        }
        *{
            /*font-size: 12px;*/
            /*font-family: dot-metrix;*/
        }
        
        @media print {
            * {
                /*font-family: 'dot-metrix' !important;*/
            }
            .no-print { 
                display: none; 
            }

        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <table border="0" cellspacing="0" cellpadding="10" style="width: 100%;">
                    <tr>
                        <td style="width: 60%">
                            <table cellspacing="0" style="width: 100%">
                                <tr>
                                    <td><h3><b><?php echo $outlet['nama_outlet'] ?></b></h3></td>
                                </tr>
                                <tr>
                                    <td><?php echo $outlet['alamat'] ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $outlet['telepon'] ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $outlet['email'] ?><br><br></td>
                                </tr>
                                <?php if ($penjualan['pelanggan_umum'] != ''): ?>
                                    <tr>
                                        <td>Nama</td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $penjualan['pelanggan_umum'] ?></td>
                                    </tr>
                                <?php endif ?>
                                <?php if ($penjualan['jenis'] == 'member'): ?>
                                    <tr>
                                        <td>Ship to</td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $penjualan['nama_pelanggan'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $penjualan['alamat'] ?></td>
                                    </tr>
                                <?php else :  ?>
                                    <?php if ($penjualan['nama_pengiriman'] != '' || $penjualan['alamat_pengiriman'] != ''): ?>
                                       <tr>
                                        <td>Ship to</td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $penjualan['nama_pengiriman'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $penjualan['alamat_pengiriman'] ?></td>
                                    </tr>   
                                <?php endif ?>
                            <?php endif ?>
                        </table>
                    </td>
                    <td style="width: 40%;">
                        <table style=" width: 100%">
                            <tr>
                                <td style="width: 50%" colspan="2"><h3>Sales Invoice</h3></td>
                            </tr>
                            <tr>
                                <td width="40%">Invoice No.</td>
                                <td width="60%">: <?php echo $penjualan['faktur_penjualan'] ?></td>
                            </tr>
                            <tr>
                                <td width="40%">Tanggal</td>
                                <td width="60%">: <?php echo date('d-m-Y H:i:s',strtotime($penjualan['tgl'])) ?></td>
                            </tr>
                            <?php if ($penjualan['status'] == 'Belum Lunas'): ?>
                                <tr>
                                    <td width="40%">Jatuh Tempo</td>
                                    <td width="60%">: <?php echo date('d-m-Y',strtotime($penjualan['tgl_jatuh_tempo'])) ?></td>
                                </tr>
                            <?php endif ?>
                            <tr>
                                <td width="40%">Kasir</td>
                                <td width="60%">: <?php echo $penjualan['nama_karyawan'] ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%">
                            <tr style="border: 1px solid black; text-align: center;">
                                <td>No</td>
                                <td style="width: 35%">Deskripsi Barang</td>
                                <td style="width: 10%">Harga</td>
                                <td style="width: 5%">Diskon</td>
                                <td style="width: 10%">Qty</td>
                                <td style="width: 35%">Subtotal</td>
                            </tr>
                            <?php $no=1; foreach ($detail_penjualan as $row): ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td style=" border-bottom: 1px;padding: 2px;"><?php echo $row['nama_barang'] ?></td>
                                <?php $this->db->select($row['type_golongan'] . ' AS harga_jual');$harga_jual = $this->db->get_where('barang', ['id_barang' => $row['id_barang']])->row()->harga_jual;?>
                                <td style=" border-bottom: 1px;padding: 2px;"><?php echo number_format($harga_jual) ?></td>
                                <td style=" border-bottom: 1px;padding: 2px;"><?php echo $row['diskon'] ?></td>
                                <td style=" border-bottom: 1px;padding: 2px;"><?php echo $row['jumlah'] ?></td>
                                <td style=" border-bottom: 1px;padding: 2px;"><?php echo number_format($row['total_harga']) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <table cellspacing="0" style="width: 100%; text-align: right;margin-top: 10px">
                        <tr>
                            <td>Total Item</td>
                            <td><?php echo $penjualan['total_item'] ?></td>
                        </tr>
                        <tr>
                            <td>Total Belanja :</td>
                            <td><?php echo "Rp. " . number_format($total_belanja) ?></td>
                        </tr>
                        <tr>
                            <td>Diskon :</td>
                            <td><?php echo $penjualan['diskon'] . ' %' ?></td>
                        </tr>   
                        <tr>
                            <td>Potongan :</td>
                            <td><?php echo "Rp. " . number_format($penjualan['potongan']) ?></td>
                        </tr>
                        <tr>
                            <td>Total Bayar :</td>
                            <td><?php echo "Rp. " . number_format($penjualan['total_bayar']) ?></td>
                        </tr>
                        <tr>
                            <td>Cash :</td>
                            <td><?php echo "Rp. " . number_format($total_bayar) ?></td>
                        </tr>   
                        <?php if ($total_bayar >= $penjualan['total_bayar']): ?>
                            <tr>
                                <td>Kembalian :</td>
                                <td><?php echo "Rp. " . number_format($total_bayar - $penjualan['total_bayar']) ?></td>
                            </tr>
                        <?php else : ?>
                          <tr>
                            <td>Harus Dibayar :</td>
                            <td><?php echo "Rp. " . number_format($penjualan['total_bayar'] - $total_bayar) ?></td>
                        </tr>
                    <?php endif; ?>   
                </table>
            </td>
        </tr>
    </table>
</div>
</div>
</div>

<!-- start -->
<div class="container">
    <div class="row no-print" style="text-transform:uppercase;">
        <hr>
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="col-xs-12">
                <button onclick="window.print();" class="btn btn-block btn-flat btn-primary">CETAK</button>
            </div>
            <br>
            <br>
            <div class="col-xs-12">
                <a href="<?php echo base_url('penjualan/cetak_thermal/') . $this->uri->segment(3) ?>" class="btn btn-info btn-block btn-flat">Cetak Thermal (F5)</a>
            </div>
            <br>
            <br>
            <div class="col-xs-12">
                <a target="_blank" href="<?php echo base_url('penjualan/invoice_print/') . $this->uri->segment(3) ?>" class="btn btn-danger btn-block btn-flat">Cetak Thermal via browser (F9)</a>
            </div>
            <br>
            <br>
            <div class="col-xs-12">
                <a target="_blank" href="<?php echo base_url('penjualan/surat_jalan/' . $this->uri->segment(3) ) ?>" class="btn btn-block btn-flat btn-warning">CETAK SURAT JALAN</a>
            </div>
            <br>
            <br>
            <div class="col-xs-12">
                <a class="btn btn-block btn-success" href="<?php echo base_url('penjualan') ?>">Kembali Ke Penjualan</a>
            </div>
        </div>
    </div>
</div>

</body>
<script src="<?php echo base_url('vendor/lte/') ?>bower_components/jquery/dist/jquery.min.js"></script>
<script>

    const base_url = '<?= base_url() ?>'

    $(document).keyup(function (e) {
        if (e.keyCode == 116) {
            e.preventDefault();
            const url = window.location.href
            const url_data = url.split('/');
            window.location.href = base_url + 'penjualan/cetak_thermal/'  + url_data[6]
        }

        if (e.keyCode == 120) {
            e.preventDefault();
            const url = window.location.href
            const url_data = url.split('/');
            window.open(base_url + 'penjualan/invoice_print/' + url_data[6], 'mywindow');
            window.location.href = base_url + 'penjualan'
        }

    });

</script>
</html>
