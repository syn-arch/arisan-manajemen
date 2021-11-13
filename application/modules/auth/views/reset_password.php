<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Masuk E - POS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="icon" href="<?php echo base_url('assets/img/favicon.png') ?>" />
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('vendor/lte/') ?>plugins/iCheck/square/blue.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
  <div class="black"></div>
  <div class="login-box">
    <div class="login-logo">
      <a href="<?php echo base_url() ?>"><b>E - POS</b> V1.0.4</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Silahkan masukan email dan password anda</p>

      <?php if ($error = $this->session->flashdata('error')): ?>
        <span class="alert-error d-error hidden"><?php echo $error ?></span>
      <?php endif ?>
      <?php if ($warning = $this->session->flashdata('warning')): ?>
        <span class="alert-warning d-warning hidden"><?php echo $warning ?></span>
      <?php endif ?>
      <?php if ($success = $this->session->flashdata('success')): ?>
        <span class="alert-success d-success hidden"><?php echo $success ?></span>
      <?php endif ?>
      <?php if ($message = $this->session->flashdata('message')): ?>
        <span class="alert-success d-message hidden"><?php echo $message ?></span>
      <?php endif ?>


      <form method="post">
       <div class="form-group <?php if(form_error('pw1')) echo 'has-error'?>">
         <label for="pw1">Password Baru</label>
         <input type="password" id="pw1" name="pw1" class="form-control pw1 " placeholder="Password Baru" value="<?php echo set_value('pw1') ?>">
         <?php echo form_error('pw1', '<small style="color:red">','</small>') ?>
       </div>
       <div class="form-group <?php if(form_error('pw2')) echo 'has-error'?>">
         <label for="pw2">Konfirmasi Password Baru</label>
         <input type="password" id="pw2" name="pw2" class="form-control pw2 " placeholder="Konfirmasi Password Baru" value="<?php echo set_value('pw2') ?>">
         <?php echo form_error('pw2', '<small style="color:red">','</small>') ?>
       </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-xs-12">
            <button type="submit" class="btn btn-danger btn-block btn-flat">Ubah Password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery 3 -->
  <script src="<?php echo base_url('vendor/lte/') ?>bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo base_url('vendor/lte/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="<?php echo base_url('vendor/lte/') ?>plugins/iCheck/icheck.min.js"></script>
  <script src="<?php echo base_url('vendor/sweetalert/sweetalert.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/alert.js') ?>"></script>
</body>
</html>
