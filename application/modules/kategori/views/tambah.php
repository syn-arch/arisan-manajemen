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
            <a href="<?php echo base_url('master/kategori') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
          </div>
        </div>
      </div>
      <div class="box-body">
       <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
         <form method="POST" enctype="multipart/form-data">
          <div class="form-group <?php if(form_error('id_kategori')) echo 'has-error'?>">
            <label for="id_kategori">ID kategori</label>
            <input readonly="" type="text" id="id_kategori" name="id_kategori" class="form-control id_kategori " placeholder="ID kategori" value="<?php echo autoID('KTR', 'kategori') ?>">
            <?php echo form_error('id_kategori', '<small style="color:red">','</small>') ?>
          </div>
          <div class="form-group <?php if(form_error('nama_kategori')) echo 'has-error'?>">
           <label for="nama_kategori">Nama kategori</label>
           <input type="text" id="nama_kategori" name="nama_kategori" class="form-control nama_kategori" placeholder="Nama kategori" value="<?php echo set_value('nama_kategori') ?>">
           <?php echo form_error('nama_kategori', '<small style="color:red">','</small>') ?>
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