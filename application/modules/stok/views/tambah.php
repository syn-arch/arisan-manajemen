<form method="POST" enctype="multipart/form-data">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-danger">
        <div class="box-header with-border">
          <div class="pull-left">
            <div class="box-title">
              <h4><?php echo $judul ?></h4>
              <small>Gunakan minus untuk mengurangi data stok misal (-5) dan sebaliknya untuk menambah data stok (5)</small>
            </div>
          </div>
          <div class="pull-right">
            <div class="box-title">
              <a href="<?php echo base_url('stok') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
          </div>
        </div>
        <div class="box-body">
         <div class="row">
          <div class="col-md-6">
            <input type="hidden" name="id_petugas" value="<?php echo $this->session->userdata('id_petugas'); ?>">
            <div class="form-group <?php if(form_error('id_stok')) echo 'has-error'?>">
              <label for="id_stok">ID Stok</label>
              <input readonly="" type="text" id="id_stok" name="id_stok" class="form-control id_stok " placeholder="ID Stok" value="<?php echo autoID('STK', 'stok') ?>">
              <?php echo form_error('id_stok', '<small style="color:red">','</small>') ?>
            </div>
            <div class="form-group <?php if(form_error('nama_petugas')) echo 'has-error'?>">
              <label for="nama_petugas">Nama Petugas</label>
              <input readonly="" type="text" id="nama_petugas" name="nama_petugas" class="form-control nama_petugas " placeholder="Nama Petugas" value="<?php echo $this->session->userdata('nama_petugas'); ?>">
              <?php echo form_error('nama_petugas', '<small style="color:red">','</small>') ?>
            </div>
            <div class="form-group <?php if(form_error('tgl')) echo 'has-error'?>">
              <label for="tgl">Tanggal</label>
              <input readonly="" type="text" id="tgl" name="tgl" class="form-control tgl " placeholder="Tanggal" value="<?php echo date('Y-m-d H:i:s') ?>">
              <?php echo form_error('tgl', '<small style="color:red">','</small>') ?>
            </div>
          </div>
          <div class="col-md-6">
           <div class="form-group <?php if(form_error('dari')) echo 'has-error'?>">
            <label for="dari">Dari</label>
            <select name="dari" id="dari" class="form-control select2">
              <option value="Gudang">Gudang</option>
              <?php foreach ($outlet as $row): ?>
                <option value="<?php echo $row['id_outlet'] ?>"><?php echo $row['nama_outlet'] ?></option>
              <?php endforeach ?>
            </select>
            <?php echo form_error('id_outlet', '<small style="color:red">','</small>') ?>
          </div>
           <div class="form-group <?php if(form_error('ke')) echo 'has-error'?>">
            <label for="ke">Ke</label>
            <select name="ke" id="ke" class="form-control select2">
              <?php foreach ($outlet as $row): ?>
                <option value="<?php echo $row['id_outlet'] ?>"><?php echo $row['nama_outlet'] ?></option>
              <?php endforeach ?>
            </select>
            <?php echo form_error('id_outlet', '<small style="color:red">','</small>') ?>
          </div>
          <div class="form-group <?php if(form_error('keterangan')) echo 'has-error'?>">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" cols="30" rows="4" class="form-control" placeholder="Keterangan"></textarea>
            <?php echo form_error('keterangan', '<small style="color:red">','</small>') ?>
          </div>    
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div class="input-group input-group">
              <input type="text" class="form-control cari_brg_penyesuaian" placeholder="Barcode Atau Kode Barang">
              <span class="input-group-btn">
                <button type="button" data-toggle="modal" data-target="#modal-barang" class="btn btn-info btn-flat"><i class="fa fa-plus"></i></button>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Kode Barang</th>
                  <th>Barcode</th>
                  <th>Nama Barang</th>
                  <th>Jumlah</th>
                </tr>
              </thead>
              <tbody class="barang-stokpenyesuaian">

              </tbody>
            </table>
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


<!-- Modal -->
<div class="modal fade" id="modal-barang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Cari Barang</h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table" id="table-barang-penyesuaian-stok" width="100%">
                <thead>
                  <tr>
                    <th>Kode Barang</th>
                    <th>Barcode</th>
                    <th>Nama Barang</th>
                    <th><i class="fa fa-plus"></i></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
