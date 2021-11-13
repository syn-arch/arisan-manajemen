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
            <a href="<?php echo base_url('master/kelompok') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
          </div>
        </div>
      </div>
      <div class="box-body">
       <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
         <form method="POST" enctype="multipart/form-data">
          <div class="form-group <?php if(form_error('id_kelompok')) echo 'has-error'?>">
            <label for="id_kelompok">ID kelompok</label>
            <input readonly="" type="text" id="id_kelompok" name="id_kelompok" class="form-control id_kelompok " placeholder="ID kelompok" value="<?php echo autoID('KLP', 'kelompok') ?>">
            <?php echo form_error('id_kelompok', '<small style="color:red">','</small>') ?>
          </div>
          <div class="form-group <?php if(form_error('nama_kelompok')) echo 'has-error'?>">
           <label for="nama_kelompok">Nama kelompok</label>
           <input type="text" id="nama_kelompok" name="nama_kelompok" class="form-control nama_kelompok" placeholder="Nama kelompok" value="<?php echo set_value('nama_kelompok') ?>">
           <?php echo form_error('nama_kelompok', '<small style="color:red">','</small>') ?>
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