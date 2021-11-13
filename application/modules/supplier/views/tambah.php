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
            <a href="<?php echo base_url('master/supplier') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
          </div>
        </div>
      </div>
      <div class="box-body">
       <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
         <form method="POST" enctype="multipart/form-data">
          <div class="form-group <?php if(form_error('id_supplier')) echo 'has-error'?>">
            <label for="id_supplier">ID supplier</label>
            <input readonly="" type="text" id="id_supplier" name="id_supplier" class="form-control id_supplier " placeholder="ID supplier" value="<?php echo autoID('SPL', 'supplier') ?>">
            <?php echo form_error('id_supplier', '<small style="color:red">','</small>') ?>
          </div>
          <div class="form-group <?php if(form_error('nama_supplier')) echo 'has-error'?>">
           <label for="nama_supplier">Nama supplier</label>
           <input type="text" id="nama_supplier" name="nama_supplier" class="form-control nama_supplier" placeholder="Nama supplier" value="<?php echo set_value('nama_supplier') ?>">
           <?php echo form_error('nama_supplier', '<small style="color:red">','</small>') ?>
         </div>
         <div class="form-group <?php if(form_error('alamat')) echo 'has-error'?>">
           <label for="alamat">Alamat</label>
           <input type="text" id="alamat" name="alamat" class="form-control alamat " placeholder="Alamat" value="<?php echo set_value('alamat') ?>">
           <?php echo form_error('alamat', '<small style="color:red">','</small>') ?>
         </div>
         <div class="form-group <?php if(form_error('telepon')) echo 'has-error'?>">
           <label for="telepon">Telepon</label>
           <input type="text" id="telepon" name="telepon" class="form-control telepon " placeholder="Telepon" value="<?php echo set_value('telepon') ?>">
           <?php echo form_error('telepon', '<small style="color:red">','</small>') ?>
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