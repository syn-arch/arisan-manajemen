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
            <a href="<?php echo base_url('stok/barang?id_outlet=' . $stok['id_outlet']) ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
          </div>
        </div>
      </div>
      <div class="box-body">
       <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
         <form method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id_stok_outlet" value="<?php echo $stok['id_stok_outlet'] ?>">
           <div class="form-group <?php if(form_error('stok')) echo 'has-error'?>">
             <label for="stok">Stok Barang</label>
             <input type="text" id="stok" name="stok" class="form-control stok" placeholder="Stok Barang" value="<?php echo $stok['stok'] ?>">
             <?php echo form_error('stok', '<small style="color:red">','</small>') ?>
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