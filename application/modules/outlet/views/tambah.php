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
                        <a href="<?php echo base_url('master/outlet') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
               <div class="row">
                <div class="col-md-2"></div>
                   <div class="col-md-8">
                       <form method="POST" enctype="multipart/form-data">
                        <div class="form-group <?php if(form_error('id_outlet')) echo 'has-error'?>">
                          <label for="id_outlet">ID outlet</label>
                          <input readonly="" type="text" id="id_outlet" name="id_outlet" class="form-control id_outlet " placeholder="ID outlet" value="<?php echo autoID('OTL', 'outlet') ?>">
                          <?php echo form_error('id_outlet', '<small style="color:red">','</small>') ?>
                        </div>
                           <div class="form-group <?php if(form_error('nama_outlet')) echo 'has-error'?>">
                               <label for="nama_outlet">Nama outlet</label>
                               <input type="text" id="nama_outlet" name="nama_outlet" class="form-control nama_outlet" placeholder="Nama outlet" value="<?php echo set_value('nama_outlet') ?>">
                               <?php echo form_error('nama_outlet', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('alamat')) echo 'has-error'?>" >
                               <label for="alamat">Alamat</label>
                               <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control " placeholder="alamat"><?php echo set_value('alamat') ?></textarea>
                               <?php echo form_error('alamat', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('telepon')) echo 'has-error'?>">
                             <label for="telepon">Telepon</label>
                             <input type="text" id="telepon" name="telepon" class="form-control telepon " placeholder="Telepon" value="<?php echo set_value('telepon') ?>">
                             <?php echo form_error('telepon', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('email')) echo 'has-error'?>">
                             <label for="email">E-mail</label>
                             <input type="text" id="email" name="email" class="form-control email " placeholder="E-mail" value="<?php echo set_value('email') ?>">
                             <?php echo form_error('email', '<small style="color:red">','</small>') ?>
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