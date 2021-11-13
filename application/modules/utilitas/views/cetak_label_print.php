<?php require './vendor/autoload.php'; $generator = new Picqer\Barcode\BarcodeGeneratorPNG(); ?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Cetak Label</title>
  <style>
    body {
      width: 8.5in;
      margin: 0in .1875in;
    }

    .wrapper{
      margin: auto;
    }

    .label{
      margin-top: .125in;
      /* Avery 5160 labels -- CSS and HTML by MM at Boulder Information Services */
      width: 3.025in; /* plus .6 inches from padding */
      /* height: 1.875in; /* plus .125 inches from padding  */
      height: 0.7in;
      padding: .125in .3in 0;
      margin-right: .125in; /* the gutter */
      float: left;
      text-align: center;
      overflow: hidden;
      outline: 1px dotted; /* outline doesn't occupy space like border does */
    }
    .page-break  {
      clear: left;
      display:block;
      page-break-after:always;
    }
  </style>
</head>
<body onload="window.print()">
  <div class="wrapper">
    <?php for ($i=1; $i <= $_POST['jumlah']; $i++) : ?>
    <?php foreach ($barcode['nama_barang'] as $index => $row): ?>
      <div class="label">
        <?php echo $row ?>
        <br>
        <img src="data:image/png;base64,<?php echo base64_encode($generator->getBarcode($barcode['barcode'][$index], $generator::TYPE_CODE_128)) ?>">
        <br>
      </div>
    <?php endforeach ?>
  <?php endfor; ?>
  </div>
  <div class="page-break"></div>
</body>
</html>