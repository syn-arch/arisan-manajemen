<form method="POST" enctype="multipart/form-data">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-danger">
        <div class="box-header with-border">
          <div class="pull-left">
            <div class="box-title">
              <h4><?php echo $judul  ?></h4>
            </div>
          </div>
          <div class="pull-right">
            <div class="box-title">
              <a href="<?php echo base_url('pulsa/riwayat') ?>" class="btn btn-success"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <input type="hidden" name="id_pulsa" value="<?php echo $pulsa['id_pulsa'] ?>">
              <input type="hidden" name="id_petugas" value="<?php echo $pulsa['id_petugas'] ?>">
              <input type="hidden" name="id_outlet" value="<?php echo $pulsa['id_outlet'] ?>">
              <div class="form-group <?php if(form_error('tgl')) echo 'has-error'?>">
                <label for="tgl">Tanggal</label>
                <input type="datetime-local" id="tgl" name="tgl" class="form-control tgl " placeholder="Tanggal" value="<?php echo $pulsa['tgl'] ?>">
                <?php echo form_error('tgl', '<small style="color:red">','</small>') ?>
              </div>
              <div class="form-group <?php if(form_error('no_telepon')) echo 'has-error'?>">
                <label for="no_telepon">No Telepon</label>
                <input type="text" id="no_telepon" name="no_telepon" class="form-control no_telepon " placeholder="No Telepon" value="<?php echo $pulsa['no_telepon'] ?>">
                <?php echo form_error('no_telepon', '<small style="color:red">','</small>') ?>
              </div>
              <div class="form-group <?php if(form_error('saldo_awal')) echo 'has-error'?>">
                <label for="saldo_awal">Saldo Awal</label>
                <input type="text" id="saldo_awal" name="saldo_awal" class="form-control saldo_awal " placeholder="Saldo Awal" value="<?php echo $pulsa['saldo_awal'] ?>">
                <?php echo form_error('saldo_awal', '<small style="color:red">','</small>') ?>
              </div>
              <div class="form-group <?php if(form_error('harga_pulsa')) echo 'has-error'?>">
                <label for="harga_pulsa">Harga Pulsa</label>
                <input type="text" id="harga_pulsa" name="harga_pulsa" class="form-control harga_pulsa " placeholder="Harga Pulsa" value="<?php echo $pulsa['harga_pulsa'] ?>">
                <?php echo form_error('harga_pulsa', '<small style="color:red">','</small>') ?>
              </div>
              <div class="form-group <?php if(form_error('saldo_akhir')) echo 'has-error'?>">
                <label for="saldo_akhir">Saldo Akhir</label>
                <input type="text" id="saldo_akhir" name="saldo_akhir" class="form-control saldo_akhir " placeholder="Saldo Akhir" value="<?php echo $pulsa['saldo_akhir'] ?>">
                <?php echo form_error('saldo_akhir', '<small style="color:red">','</small>') ?>
              </div>
              <div class="form-group <?php if(form_error('keterangan')) echo 'has-error'?>">
                <label for="keterangan">Keterangan</label>
               <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control" placeholder="Keterangan"><?php echo $pulsa['keterangan'] ?></textarea>
                <?php echo form_error('keterangan', '<small style="color:red">','</small>') ?>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-danger btn-block">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>