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
                        <a href="<?php echo base_url('master/pelanggan') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
               <div class="row">
                <div class="col-md-2"></div>
                   <div class="col-md-8">
                       <form method="POST" enctype="multipart/form-data">
                        <div class="form-group <?php if(form_error('id_pelanggan')) echo 'has-error'?>">
                          <label for="id_pelanggan">ID pelanggan</label>
                          <input readonly="" type="text" id="id_pelanggan" name="id_pelanggan" class="form-control" value="<?php echo $pelanggan['id_pelanggan'] ?>">
                          <?php echo form_error('id_pelanggan', '<small style="color:red">','</small>') ?>
                        </div>
                        <div class="form-group <?php if(form_error('barcode')) echo 'has-error'?>">
                          <label for="barcode">Barcode</label>
                          <input type="text" id="barcode" name="barcode" class="form-control barcode " placeholder="Barcode" value="<?php echo $pelanggan['barcode'] ?>">
                          <?php echo form_error('barcode', '<small style="color:red">','</small>') ?>
                        </div>
                           <div class="form-group <?php if(form_error('nama_pelanggan')) echo 'has-error'?>">
                               <label for="nama_pelanggan">Nama pelanggan</label>
                               <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control nama_pelanggan" placeholder="Nama pelanggan" value="<?php echo $pelanggan['nama_pelanggan'] ?>">
                               <?php echo form_error('nama_pelanggan', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('jk')) echo 'has-error'?>">
                               <label for="jk">Jenis Kelamin</label><br>
                               <select name="jk" id="jk" class="form-control">
                                   <option value="">-- Silahkan Pilih Jenis Kelamin --</option>
                                   <option value="L" <?php echo $pelanggan['jk'] == "L" ? 'selected' : '' ?>>Laki-Laki</option>
                                   <option value="P" <?php echo $pelanggan['jk'] == "P" ? 'selected' : '' ?>>Perempuan</option>
                               </select>
                               <?php echo form_error('jk', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('alamat')) echo 'has-error'?>" >
                               <label for="alamat">Alamat</label>
                               <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control " placeholder="alamat"><?php echo $pelanggan['alamat'] ?></textarea>
                               <?php echo form_error('alamat', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('telepon')) echo 'has-error'?>">
                               <label for="telepon">Telepon</label>
                               <input type="text" id="telepon" name="telepon" class="form-control telepon " placeholder="Telepon" value="<?php echo $pelanggan['telepon'] ?>">
                               <?php echo form_error('telepon', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('jenis')) echo 'has-error'?>">
                               <label for="jenis">Jenis Pelanggan</label><br>
                               <select name="jenis" id="jenis" class="form-control">
                                   <option value="">-- Silahkan Pilih Jenis Pelanggan --</option>
                                   <option value="umum" <?php echo $pelanggan['jenis']== "umum" ? 'selected' : '' ?>>Umum</option>
                                   <option value="member" <?php echo $pelanggan['jenis']== "member" ? 'selected' : '' ?>>Member</option>
                               </select>
                               <?php echo form_error('jenis', '<small style="color:red">','</small>') ?>
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