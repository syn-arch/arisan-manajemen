<?php 
$url = $this->db->get('pengaturan')->row()->url_server;
if ($idtl = $this->session->userdata('id_outlet')) {
  $id_outlet = $idtl;
}else{
  $id_outlet = $this->db->get('outlet')->row()->id_outlet;
}
?>

<style>
  .loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  
</style>

<div class="row">
  <div class="col-xs-12">
    <div class="box box-danger">
      <div class="box-header with-border">
        <div class="pull-left">
          <div class="box-title">
            <h4><?php echo $judul ?></h4>
          </div>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <form action="<?php echo base_url('utilitas/update_url') ?>" method="POST">
              <div class="form-group <?php if(form_error('url_server')) echo 'has-error'?>">
                <label for="url_server">Alamat Server</label>
                <input type="text" id="url_server" name="url_server" class="form-control url_server " placeholder="Alamat Server" value="<?php echo $url_server ?>">
                <?php echo form_error('url_server', '<small style="color:red">','</small>') ?>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Update</button>
              </div>
              <div class="form-group">
                <label for="tgl">Tanggal yang akan disinkronkan</label>
                <input type="date" id="tgl" name="tgl" class="form-control tgl_sinkron <?php if(form_error('tgl')) echo 'is-invalid'?>" placeholder="Tanggal" value="<?php echo date("Y-m-d") ?>">
                <?php echo form_error('tgl', '<small style="color:red">','</small>') ?>
              </div>
            </form>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <button type="submit" class="btn btn-success btn-block download_data_transaksi"><i class="fa fa-refresh"></i> Update Data Transaksi</button>
            <br>
            <button type="submit" class="btn btn-danger btn-block upload_data_transaksi"><i class="fa fa-refresh"></i> Kirim Data Transaksi</button>
            <br>
            <button type="submit" class="btn btn-info btn-block download_data_master"><i class="fa fa-refresh"></i> Update Data Master</button>
            <br>
            <button type="submit" class="btn btn-warning btn-block download_stok"><i class="fa fa-refresh"></i> Update Stok</button>

          </div>
        </div>
      </div>
      <div class="box-footer">
        <br>
        <div class="col-md-12">
          <div class="col-md-5"></div>
          <div class="col-md-2 loader_wrapper">
          </div>
        </div>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
      </div>
    </div>
  </div>
</div>

<script>
  const url_server = '<?php echo $url ?>';
  const id_outlet = '<?php echo $id_outlet ?>';
</script>
