<?php 

require './vendor/autoload.php';
$generator = new Picqer\Barcode\BarcodeGeneratorPNG();

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Kartu Member</title>
	<style>
		*{
			font-family: "Montserrat" !important;
			margin: 0;
			padding: 0;

		}

		.barcode{
			display: block;
			background: url(<?php echo base_url('assets/') ?>img/ean13.jpg) no-repeat;
			background-size: contain;
			width: 100%;
			height: 80px;
			background-position: 100%,0;

		}

		.ult{
			display: flex;
			width: 100%;
			flex-wrap: wrap;
		}

		.container{
			width: 350px;
			height: auto;
			margin: 2px;
			transform: scale(.7);

		}

		.card{
			background: url(<?php echo base_url() ?>assets/img/card-frame.png) no-repeat;
			width: 500px;
			height: 300px;
			background-size: contain;
			display: flex;
			justify-content: center;

		}

		.card2{
			background: url(<?php echo base_url() ?>assets/img/depan.png) no-repeat;
			width: 500px;
			height: 300px;
			background-size: contain;
			display: flex;
			justify-content: center;

		}
		.card-text{
			width: 100%;
			padding: 40px;
		}

		.card-title{
			letter-spacing: 10px;
			font-weight: initial;
			font-size: 38px;
			line-height: 40px;
		}

		.mini{
			font-size: 12px;
		}

		.line-divider{
			border-top: 2px solid #333333;
			margin-top: 5px;
			margin-bottom: 5px;
			width: 70%;
		}

		.name{
			text-transform: capitalize;
			font-size: 26px;
		}

		.address{
			text-transform: capitalize;
			font-weight: initial;
		}

		.phone{
			text-transform: capitalize;
		}
	</style>
</head>
<body onload="window.print()">

	<div class="ult">

		<div class="container">
			<div class="card">
				<div class="card-text">
					<h1 class="card-title">
						ANNISA
					</h1>
					<b class="mini">COMPUTER</b>
					<hr class="line-divider">
					<p class="name">
						<?php echo $pelanggan['nama_pelanggan'] ?>
					</p>
					<p class="address">
						<?php echo $pelanggan['alamat'] ?>
					</p>
					<p class="phone">
						<?php echo $pelanggan['telepon'] ?>
					</p>
					<img src="data:image/png;base64,<?php echo base64_encode($generator->getBarcode($pelanggan['barcode'], $generator::TYPE_CODE_128)) ?>">
				</div>
			</div>
		</div>

		<div class="container">
			<div class="card2">
			</div>
		</div>

		

	</div>

	
</body>
</html>