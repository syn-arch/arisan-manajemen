<form method="POST" enctype="multipart/form-data">
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
          <div class="col-md-6">
            <input type="hidden" name="id_petugas" value="<?php echo $this->session->userdata('id_petugas'); ?>">
            <div class="form-group <?php if(form_error('id_biaya')) echo 'has-error'?>">
              <label for="id_biaya">ID biaya</label>
              <input readonly="" type="text" id="id_biaya" name="id_biaya" class="form-control id_biaya " placeholder="ID biaya" value="<?php echo autoIDBiaya() ?>">
              <?php echo form_error('id_biaya', '<small style="color:red">','</small>') ?>
            </div>
            <div class="form-group <?php if(form_error('nama_petugas')) echo 'has-error'?>">
              <label for="nama_petugas">Nama Petugas</label>
              <input readonly="" type="text" id="nama_petugas" name="nama_petugas" class="form-control nama_petugas " placeholder="Nama Petugas" value="<?php echo $this->session->userdata('nama_petugas'); ?>">
              <?php echo form_error('nama_petugas', '<small style="color:red">','</small>') ?>
            </div>
            <div class="form-group <?php if(form_error('tgl')) echo 'has-error'?>">
              <label for="tgl">Tanggal</label>
              <input required="" type="datetime-local" id="tgl" name="tgl" class="form-control tgl " placeholder="Tanggal" value="<?php echo date("Y-m-d\TH:i:s", strtotime( date('Y-m-d H:i:s') ))  ?>">
              <?php echo form_error('tgl', '<small style="color:red">','</small>') ?>
            </div>
            <div class="form-group">
              <label for="keterangan_biaya">Nama Biaya</label>
              <input type="text" id="keterangan_biaya" name="keterangan_biaya" class="form-control keterangan_biaya <?php if(form_error('keterangan_biaya')) echo 'is-invalid'?>" placeholder="Biaya" value="<?php echo set_value('keterangan_biaya') ?>">
              <?php echo form_error('keterangan_biaya', '<small style="color:red">','</small>') ?>
            </div>
            <div class="form-group">
              <label for="total_bayar">Total</label>
              <input type="text" id="total_bayar" name="total_bayar" class="form-control total_bayar <?php if(form_error('total_bayar')) echo 'is-invalid'?>" placeholder="Total" value="<?php echo set_value('total_bayar') ?>">
              <?php echo form_error('total_bayar', '<small style="color:red">','</small>') ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group <?php if(form_error('keterangan')) echo 'has-error'?>">
              <label for="keterangan">Keterangan</label>
              <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Keterangan"></textarea>
              <?php echo form_error('keterangan', '<small style="color:red">','</small>') ?>
            </div>    
            <div class="form-group">
              <label for="id_outlet">Outlet</label>
              <select name="id_outlet" id="id" class="form-control select2">
                <?php foreach ($outlet as $row): ?>
                  <option value="<?php echo $row['id_outlet'] ?>"><?php echo $row['nama_outlet'] ?></option>
                <?php endforeach ?>
              </select>
              <?php echo form_error('id_outlet', '<small style="color:red">','</small>') ?>
            </div>
            <div class="form-group">
              <label for="status">Status</label>
              <select name="status" id="status" class="form-control">
                <option value="PENGELUARAN">PENGELUARAN</option>
                <option value="PEMASUKAN">PEMASUKAN</option>
              </select>
              <?php echo form_error('status', '<small style="color:red">','</small>') ?>
            </div>
          </div>
        </div>
        <br><br>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <button type="submit" class="btn btn-danger btn-block">Konfirmasi</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
