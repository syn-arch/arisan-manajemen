
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Lupa Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition lockscreen">
  <!-- Automatic element centering -->
  <div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
      <a href="<?php echo base_url() ?>"><b>E - </b>POS</a>
    </div>
    <!-- User name -->
    <div class="lockscreen-name">Masukan Email</div>

      <?php if ($error = $this->session->flashdata('error')): ?>
        <span class="alert-error d-error hidden"><?php echo $error ?></span>
      <?php endif ?>
      <?php if ($warning = $this->session->flashdata('warning')): ?>
        <span class="alert-warning d-warning hidden"><?php echo $warning ?></span>
      <?php endif ?>
      <?php if ($success = $this->session->flashdata('success')): ?>
        <span class="alert-success d-success hidden"><?php echo $success ?></span>
      <?php endif ?>

    <!-- START LOCK SCREEN ITEM -->
    <div class="lockscreen-item">
      <!-- lockscreen image -->
      <div class="lockscreen-image">
        <i class="fa fa-key fa-5x"></i>
      </div>
      <!-- /.lockscreen-image -->

      <!-- lockscreen credentials (contains the form) -->
      <form class="lockscreen-credentials" method="POST">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Email.." name="email">
          <?php echo form_error('email', '<small style="color:red">','</small>') ?>
          <div class="input-group-btn">
            <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
          </div>
        </div>
      </form>
      <!-- /.lockscreen credentials -->

    </div>
    <!-- /.lockscreen-item -->
    <div class="help-block text-center">
      Masukan email untuk mereset password
    </div>
    <div class="text-center">
      <a href="<?php echo base_url('login') ?>">Kembali ke halaman login</a>
    </div>
    <div class="lockscreen-footer text-center">
      Copyright &copy; 2020 <b><a href="<?php echo base_url() ?>" class="text-black">E-POS</a></b><br>
      All rights reserved
    </div>
  </div>
  <!-- /.center -->

  <!-- jQuery 3 -->
  <script src="<?php echo base_url('vendor/lte/') ?>bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo base_url('vendor/lte/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url('vendor/sweetalert/sweetalert.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/alert.js') ?>"></script>
</body>
</html>
