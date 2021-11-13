<?php 
$this->db->join('role', 'id_role', 'left');
$petugas = $this->db->get_where('petugas',['id_petugas' => $this->session->userdata('id_petugas')])->row_array(); 
if (!$petugas) {
  $this->session->sess_destroy();
  redirect('login','refresh');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="base_url" content="<?php echo base_url() ?>">
  <title><?php echo $judul ?></title>
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

  <script src="<?php echo base_url('vendor/lte/') ?>bower_components/jquery/dist/jquery.min.js"></script>

  <script src="<?php echo base_url('vendor/lte/') ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url('vendor/lte/') ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

  <link href="<?php echo base_url('assets/datatable/') ?>keyTable.dataTables.css" rel="stylesheet" type="text/css" />
  <script src="<?php echo base_url('assets/datatable/') ?>dataTables.keyTable.js"></script>

  <link href="<?php echo base_url('assets/datatable/') ?>select.dataTables.css?.css" rel="stylesheet" type="text/css" />
  <script src="<?php echo base_url('assets/datatable/') ?>dataTables.select.js?"></script>
</head>
<body class="hold-transition skin-red sidebar-mini <?php if($judul == "Penjualan" || $judul == "Pembelian" || $judul == "Pengembalian" || $judul == "Ubah Penjualan" || $judul == "Ubah Pembelian") echo "sidebar-collapse" ?>">
  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
      <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><i class="fa fa-shopping-cart"></i></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b><i class="fa fa-shopping-cart"></i> E - POS</b></span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- close register button -->
            <?php if ($judul == 'Penjualan' || $judul == 'Pembelian'): ?>
              <li>
                <a href="#modal-shortcut" data-toggle="modal">
                  <i class="fa fa-link"></i> Shorcut
                </a>
              </li>
            <?php endif ?>
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <i class="fa fa-user fa-lg"></i>
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?php echo $petugas['nama_petugas'] ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="<?php echo base_url('assets/img/petugas/') . $petugas['gambar'] ?>" class="img-circle" alt="User Image">
                  <p>
                    <?php echo $petugas['nama_petugas'] ?>
                    <small><?php echo $this->session->userdata('level'); ?></small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?php echo base_url('profil') ?>" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="<?php echo base_url('logout') ?>" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <aside class="main-sidebar">
      <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN MENU</li>

          <?php 
          $this->db->select('*');
          $this->db->where('id_role', $this->session->userdata('id_role'));
          $this->db->order_by('urutan', 'asc');
          $this->db->join('menu', 'id_menu');
          $this->db->join('role', 'id_role');
          $menu = $this->db->get('akses_role')->result_array();
          ?>

          <?php foreach ($menu as $row): ?>
            <?php if ($row['ada_submenu'] == 0 && $row['submenu'] == 0 ): ?>
              <li <?php echo $row['nama_menu'] == $judul ? 'class="active"' : '' ?>><a href="<?php echo base_url($row['url']) ?>"><i class="<?php echo $row['icon'] ?>"></i> <span><?php echo $row['nama_menu'] ?></span></a></li>
            <?php elseif($row['ada_submenu'] == 1 && $row['submenu'] == 0) : ?>
              <?php
              $this->db->where('nama_menu', $judul);
              $this->db->where('submenu !=', 0);
              $menu_parent = $this->db->get('menu')->row_array();
              if ($menu_parent) {
                $id_menu_parent = $menu_parent['submenu'];
                $nama_menu_parent = $this->db->get_where('menu', ['id_menu' => $id_menu_parent])->row_array()['nama_menu'];
              }
              ?>
              <li class="treeview 
              <?php 
              if($menu_parent){
                echo $row['nama_menu'] == $nama_menu_parent ? 'active' : '';
              }
              ?>
              ">
              <a href="#"><i class="<?php echo $row['icon'] ?>"></i> <span><?php echo $row['nama_menu'] ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php 
                $this->db->select('*');
                $this->db->where('id_role', $this->session->userdata('id_role'));
                $this->db->where('submenu', $row['id_menu']);
                $this->db->order_by('urutan', 'asc');
                $this->db->join('menu', 'id_menu');
                $this->db->join('role', 'id_role');
                $submenu = $this->db->get('akses_role')->result_array();
                ?>
                <?php foreach ($submenu as $row_submenu): ?>
                  <li <?php echo $row_submenu['nama_menu'] == $judul ? 'class="active"' : '' ?>><a class="<?= $row_submenu['nama_menu'] == "Buka Laci" ? 'buka_laci' : '' ?>" href="<?php echo base_url($row_submenu['url']) ?>"><?php echo $row_submenu['nama_menu'] ?></a></li>
                <?php endforeach ?>
              </ul>
            </li>
          <?php endif ?>
        <?php endforeach ?>

        <li><a class="log_out" href="<?php echo base_url('logout') ?>"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>

      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <?php if ($judul != 'Pembelian'): ?>
      <?php if ($judul != 'Penjualan'): ?>
        <?php if ($judul != 'Pengembalian'): ?>
          <?php if ($judul != 'Ubah Penjualan'): ?>
            <?php if ($judul != 'Ubah Pembelian'): ?>
              <section class="content-header">
                <h1>
                  <?php echo $judul ?>
                </h1>
              </section>
            <?php endif ?>
          <?php endif ?>
        <?php endif ?>
      <?php endif ?>
    <?php endif ?>

    <!-- Main content -->
    <section class="content container-fluid">

     <?php if ($error = $this->session->flashdata('error')): ?>
      <span class="alert-error hidden d-error"><?php echo $error ?></span>
    <?php endif ?>
    <?php if ($warning = $this->session->flashdata('warning')): ?>
      <span class="alert-warning hidden d-warning"><?php echo $warning ?></span>
    <?php endif ?>
    <?php if ($success = $this->session->flashdata('success')): ?>
      <span class="alert-success hidden d-success"><?php echo $success ?></span>
    <?php endif ?>
    <?php if ($message = $this->session->flashdata('message')): ?>
      <span class="alert-message hidden d-message"><?php echo $message ?></span>
    <?php endif ?>

    <!-- modal -->
    <div class="modal fade" id="modal-shortcut">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Daftar Shortcut</h4>
            </div>
            <div class="modal-body">
              <table class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Shortcut</th>
                    <th>Deskripsi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>F1</td>
                    <td>Cari barang</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>F2</td>
                    <td>Diskon penjualan</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>F3</td>
                    <td>Barcode</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>F4</td>
                    <td>Cash penjualan (pembayaran)</td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>F11</td>
                    <td>Mode layar penuh</td>
                  </tr>
                  <tr>
                    <td>6</td>
                    <td>ALT + <-</td>
                      <td>Kembali ke halaman sebelumnya</td>
                    </tr>
                    <tr>
                      <td>7</td>
                      <td>ALT + -></td>
                      <td>Pergi ke halaman selanjutnya</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
