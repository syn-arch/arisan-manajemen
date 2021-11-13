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
                        <a href="<?php echo base_url('master/karyawan') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
               <div class="row">
                <div class="col-md-2"></div>
                   <div class="col-md-8">
                       <form method="POST" enctype="multipart/form-data">
                        <div class="form-group <?php if(form_error('id_karyawan')) echo 'has-error'?>">
                          <label for="id_karyawan">ID karyawan</label>
                          <input readonly="" type="text" id="id_karyawan" name="id_karyawan" class="form-control id_karyawan " placeholder="ID karyawan" value="<?php echo autoID('KRY', 'karyawan') ?>">
                          <?php echo form_error('id_karyawan', '<small style="color:red">','</small>') ?>
                        </div>
                           <div class="form-group <?php if(form_error('nama_karyawan')) echo 'has-error'?>">
                               <label for="nama_karyawan">Nama karyawan</label>
                               <input type="text" id="nama_karyawan" name="nama_karyawan" class="form-control nama_karyawan" placeholder="Nama karyawan" value="<?php echo set_value('nama_karyawan') ?>">
                               <?php echo form_error('nama_karyawan', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('jk')) echo 'has-error'?>">
                               <label for="jk">Jenis Kelamin</label><br>
                               <select name="jk" id="jk" class="form-control">
                                   <option value="">-- Silahkan Pilih Jenis Kelamin --</option>
                                   <option value="L" <?php echo set_value('jk') == "L" ? 'selected' : '' ?>>Laki-Laki</option>
                                   <option value="P" <?php echo set_value('jk') == "P" ? 'selected' : '' ?>>Perempuan</option>
                               </select>
                               <?php echo form_error('jk', '<small style="color:red">','</small>') ?>
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
                               <label for="E-mail">E-mail</label>
                               <input type="text" id="E-mail" name="email" class="form-control E-mail " placeholder="E-mail" value="<?php echo set_value('email') ?>">
                               <?php echo form_error('E-mail', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('jabatan')) echo 'has-error'?>">
                             <label for="jabatan">Jabatan</label>
                             <input type="text" id="jabatan" name="jabatan" class="form-control jabatan " placeholder="Jabatan" value="<?php echo set_value('jabatan') ?>">
                             <?php echo form_error('jabatan', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('gambar')) echo 'has-error'?>">
                               <label for="gambar">Gambar</label>
                               <input type="file" id="gambar" name="gambar" class="form-control gambar " placeholder="Gambar" value="<?php echo set_value('gambar') ?>">
                               <?php echo form_error('gambar', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('id_outlet')) echo 'has-error'?>">
                               <label for="id_outlet">Outlet</label>
                               <select name="id_outlet" id="id_outlet" class="form-control">
                                   <option value="">-- Silahkan Pilih Outlet ---</option>
                                   <?php foreach ($outlet as $row): ?>
                                       <option value="<?php echo $row['id_outlet'] ?>" <?php echo set_value('id_outlet') == $row['id_outlet'] ? 'selected' : '' ?>><?php echo $row['nama_outlet'] ?></option>
                                   <?php endforeach ?>
                               </select>
                               <?php echo form_error('id_outlet', '<small style="color:red">','</small>') ?>
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