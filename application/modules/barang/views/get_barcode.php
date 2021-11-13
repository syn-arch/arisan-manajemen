<?php 
require './vendor/autoload.php';
$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
$a = new Picqer\Barcode\BarcodeGeneratorSVG();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="base_url" content="<?php echo base_url() ?>">
  <title>Generate Barcode</title>
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
  <style>
    * {
      margin: 0;
      padding: 0;
    }
  </style>
</head>
<body onload="window.print()">

  <table class="table text-center" width="100%">
    <tr>
      <td>
       <p><?= $barang['nama_barang'] ?></p>
       <p><?= "Rp. " . number_format($barang['golongan_1']) ?></p>
       <?php if($barang['barcode']) : ?>
       <img src="data:image/png;base64,<?php echo base64_encode($generator->getBarcode($barang['barcode'], $generator::TYPE_CODE_128)) ?>">
       <?php endif ?>
       <p class="nama_toko"><?php echo $this->db->get('outlet')->row()->nama_outlet ?></p>
     </td>
    </tr>
  </table>

</body>
</html>
