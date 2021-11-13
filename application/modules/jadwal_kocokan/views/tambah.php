<div class="row">
  <div class="col-xs-12">
    <div class="box box-danger">
      <div class="box-header with-border">
        <div class="pull-left">
          <div class="box-title">
            <h4><?php echo $judul ?></h4>
          </div>
        </div>
        <div class="pull-right">
          <div class="box-title">
            <a href="<?php echo base_url('master/jadwal_kocokan') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
          </div>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <form method="POST" enctype="multipart/form-data">
              <div class="form-group <?php if(form_error('id_jadwal_kocokan')) echo 'has-error'?>">
                <label for="id_jadwal_kocokan">ID Jadwal Kocokan</label>
                <input readonly="" type="text" id="id_jadwal_kocokan" name="id_jadwal_kocokan" class="form-control id_jadwal_kocokan " placeholder="ID jadwal_kocokan" value="<?php echo autoID('JDW', 'jadwal_kocokan') ?>">
                <?php echo form_error('id_jadwal_kocokan', '<small style="color:red">','</small>') ?>
              </div>
              <div class="form-group">
                <label for="">Agen</label>
                <select required="" name="id_agen" id="id_agen" class="form-control select2 agen agen-wrapper">
                  <?php foreach ($agen as $row): ?>
                    <option value="<?php echo $row['id_agen'] ?>">
                      <?php echo $row['nama_agen'] ?>
                    </option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label for="">Kelompok</label>
                <select required="" name="id_kelompok" id="id_kelompok" class="form-control select2 kelompok kelompok-wrapper">
                  <?php foreach ($kelompok as $row): ?>
                    <option value="<?php echo $row['id_kelompok'] ?>">
                      <?php echo $row['nama_kelompok'] ?>
                    </option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label for="">Nominal</label>
                <input type="text" class="form-control" value="" name="nominal" placeholder="nominal">
              </div>
              <div class="form-group">
                <label for="">Tanggal</label>
                <input type="date" class="form-control" value="" name="tanggal">
              </div>
              <div class="form-group">
                <label for="">Keterangan</label>
                <input type="text" class="form-control" value="" name="keterangan" placeholder="keterangan">
              </div>
              <div class="form-group">
               <button type="submit" class="btn btn-danger btn-block">Submit</button>
             </div>
           </form>
         </div>
       </div>
     </div>
   </div>
 </div>
</div>