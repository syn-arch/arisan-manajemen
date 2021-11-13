<?php 
$pengaturan = $this->db->get('pengaturan')->row_array(); 
$this->db->select('*, DATEDIFF(DATE(tgl_jatuh_tempo), CURDATE()) AS jatuh_tempo');
$this->db->where('DATEDIFF(DATE(tgl_jatuh_tempo), CURDATE()) <=', 5);
$this->db->where('DATEDIFF(DATE(tgl_jatuh_tempo), CURDATE()) >', 0);
$this->db->where('status', 'Belum Lunas');
$hutang = $this->db->get('pembelian')->result_array();
$counter = 1;
?>

<?php if (!$this->session->userdata('id_outlet')): ?>
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo $this->db->get('petugas')->num_rows(); ?></h3>

          <p>Data Petugas</p>
        </div>
        <div class="icon">
          <i class="fa fa-users"></i>
        </div>
        <a href="<?php echo base_url('petugas') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?php echo $this->db->get('kategori')->num_rows(); ?></h3>

          <p>Data Kategori</p>
        </div>
        <div class="icon">
          <i class="fa fa-folder"></i>
        </div>
        <a href="<?php echo base_url('master/kategori') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?php echo $this->db->get('supplier')->num_rows(); ?></h3>

          <p>Data Supplier</p>
        </div>
        <div class="icon">
          <i class="fa fa-cube"></i>
        </div>
        <a href="<?php echo base_url('master/supplier') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo $this->db->get('barang')->num_rows(); ?></h3>

          <p>Data Barang</p>
        </div>
        <div class="icon">
          <i class="fa fa-cubes"></i>
        </div>
        <a href="<?php echo base_url('master/barang') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>
<?php endif ?>

<?php if (false): ?>
  <div class="row">
    <div class="col-lg-3 col-xs-12 col-md-6">
      <div class="info-box">
        <span class="info-box-icon bg-aqua">RP</span>
        <div class="info-box-content">
          <span class="info-box-text">Hari Ini</span>
          <?php 

          $query = "SELECT SUM(total_bayar) AS 'hari_ini' FROM `penjualan` WHERE DATE(tgl) = DATE(NOW()) AND status != 'Hold' ";
          $hari_ini = $this->db->query($query)->row_array()['hari_ini'];

          ?>
          <span class="info-box-number"><?php echo number_format($hari_ini)  ?></span>
        </div>
      </div>
    </div>
    <?php if (!$this->session->userdata('id_outlet')): ?>
      <div class="col-lg-3 col-xs-12 col-md-6">
        <div class="info-box">
          <span class="info-box-icon bg-aqua">RP</span>
          <div class="info-box-content">
            <span class="info-box-text">Bulan Ini</span>
            <?php 
            $query = "
            SElECT SUM(total_bayar) as bulan_ini
            FROM penjualan
            WHERE CONCAT(YEAR(tgl), '/', MONTH(tgl)) = CONCAT(YEAR(NOW()), '/', MONTH(NOW())) AND status != 'Hold'
            GROUP BY YEAR(tgl),MONTH(tgl)
            ";
            $bulan_ini = $this->db->query($query)->row_array();

            if ($bulan_ini) {
              $pendapatan_bulan_ini = $bulan_ini['bulan_ini'];
            }else{
              $pendapatan_bulan_ini = 0;
            }

            ?>
            <span class="info-box-number"><?php echo number_format($pendapatan_bulan_ini)  ?></span>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-xs-12 col-md-6">
        <div class="info-box">
          <span class="info-box-icon bg-aqua">RP</span>
          <div class="info-box-content">
            <span class="info-box-text">Tahun Ini</span>
            <?php 
            $query = "
            SElECT SUM(total_bayar) as tahun_ini
            FROM penjualan
            WHERE YEAR(tgl) = YEAR(NOW()) AND status != 'Hold'
            GROUP BY YEAR(tgl)
            ";
            $tahun_ini = $this->db->query($query)->row_array();

            if ($tahun_ini) {
              $pendapatan_tahun_ini = $tahun_ini['tahun_ini'];
            }else{
              $pendapatan_tahun_ini = 0;
            }

            ?>
            <span class="info-box-number"><?php echo number_format($pendapatan_tahun_ini)  ?></span>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-xs-12 col-md-6">
        <div class="info-box">
          <span class="info-box-icon bg-aqua">RP</span>
          <div class="info-box-content">
            <span class="info-box-text">Total Pendapatan</span>
            <?php 

            $this->db->select_sum('total_bayar', 'total_pendapatan');
            $total_pendapatan = $this->db->get('penjualan')->row_array()['total_pendapatan'];

            ?>
            <span class="info-box-number"><?php echo number_format($total_pendapatan)  ?></span>
          </div>
        </div>
      </div>
    <?php endif ?>
  </div>
<?php endif ?>

<?php if (false): ?>
  <!-- tombol aplikasi -->
  <div class="row">
    <div class="col-md-6">
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Tombol Aplikasi</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <a class="btn btn-app" href="<?php echo base_url('master/outlet') ?>">
                <i class="fa fa-clone"></i> Outlet
              </a>
              <a class="btn btn-app" href="<?php echo base_url('master/kategori') ?>">
                <i class="fa fa-folder"></i> Kategori
              </a>
              <a class="btn btn-app" href="<?php echo base_url('master/supplier') ?>">
                <i class="fa fa-cube"></i> Supplier
              </a>
              <a class="btn btn-app" href="<?php echo base_url('master/barang') ?>">
                <i class="fa fa-cubes"></i> Barang
              </a>
              <a class="btn btn-app" href="<?php echo base_url('master/pelanggan') ?>">
                <i class="fa fa-users"></i> Pelanggan
              </a>
              <a class="btn btn-app" href="<?php echo base_url('penjualan') ?>">
                <i class="fa fa-shopping-cart"></i> Penjualan
              </a>
              <a class="btn btn-app" href="<?php echo base_url('pembelian') ?>">
                <i class="fa fa-cart-plus"></i> Pembelian
              </a>
              <a class="btn btn-app" href="<?php echo base_url('penjualan/riwayat_penjualan') ?>">
                <i class="fa fa-book"></i> Riwayat Penjualan
              </a>
              <a class="btn btn-app" href="<?php echo base_url('laporan/riwayat_pembelian') ?>">
                <i class="fa fa-book"></i> Riwayat Pembelian
              </a>
              <a class="btn btn-app" href="<?php echo base_url('stok/stok_opname') ?>">
                <i class="fa fa-check"></i> Stok Opname
              </a>
              <a class="btn btn-app" href="<?php echo base_url('stok') ?>">
                <i class="fa fa-gear"></i> Penyesuaian Stok
              </a>
              <a class="btn btn-app" href="<?php echo base_url('stok/barang') ?>">
                <i class="fa fa-dropbox"></i> Stok Barang
              </a>
              <a class="btn btn-app" href="<?php echo base_url('laporan/per_barang_umum') ?>">
                <i class="fa fa-book"></i> Laporan Penjualan
              </a>
              <a class="btn btn-app" href="<?php echo base_url('utilitas/backup') ?>">
                <i class="fa fa-sitemap"></i> Backup DB
              </a>
              <a class="btn btn-app" href="<?php echo base_url('profil') ?>">
                <i class="fa fa-user"></i> Profil Saya
              </a>
              <a class="btn btn-app" href="<?php echo base_url('pengaturan') ?>">
                <i class="fa fa-gears"></i> pengaturan
              </a>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Statistik Penjualan <?php echo date('Y') ?></h3>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="areaChart" style="height: 286px; width: 586px;" height="572" width="1172"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- stok tipis -->
  <div class="row">
    <div class="col-md-6">
      <div class="box box-danger">
        <div class="box-header">
          <h4 class="box-title">Stok Tipis</h4>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table" id="stok-tipis">
              <thead>
                <tr>
                  <th>Kode Barang</th>
                  <th>Barcode</th>
                  <th>Nama Barang</th>
                  <th>Stok</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-danger">
        <div class="box-header">
          <h4 class="box-title">Stok habis</h4>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table" id="stok-habis">
              <thead>
                <tr>
                  <th>Kode Barang</th>
                  <th>Barcode</th>
                  <th>Nama Barang</th>
                  <th>Stok</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    <?php 

    $query = "
    SElECT MONTH(tgl) AS bulan,SUM(total_bayar) AS jumlah_transaksi
    FROM penjualan
    WHERE YEAR(tgl) = YEAR(NOW())
    GROUP BY YEAR(tgl),MONTH(tgl)
    ";
    $month = $this->db->query($query)->result_array(); 

    echo "const month = " .  json_encode($month) . ";";
    echo "const pengaturan = " .  json_encode($pengaturan);
    ?>

    const monthPure = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    const monthName = month.map(function(val){
      return monthPure[val.bulan];
    })

    const monthValue = month.map(function(val){
      return val.jumlah_transaksi;
    })
  </script>

<?php endif ?>
