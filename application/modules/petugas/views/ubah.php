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
                        <a href="<?php echo base_url('petugas') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
               <div class="row">
                <div class="col-md-2"></div>
                   <div class="col-md-8">
                       <form method="POST" enctype="multipart/form-data">
                        <div class="form-group <?php if(form_error('id_petugas')) echo 'has-error'?>">
                          <label for="id_petugas">ID Petugas</label>
                          <input readonly="" type="text" id="id_petugas" name="id_petugas" class="form-control" value="<?php echo $petugas['id_petugas'] ?>">
                          <?php echo form_error('id_petugas', '<small style="color:red">','</small>') ?>
                        </div>
                           <div class="form-group <?php if(form_error('nama_petugas')) echo 'has-error'?>">
                               <label for="nama_petugas">Nama Petugas</label>
                               <input type="text" id="nama_petugas" name="nama_petugas" class="form-control nama_petugas" placeholder="Nama Petugas" value="<?php echo $petugas['nama_petugas'] ?>">
                               <?php echo form_error('nama_petugas', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('jk')) echo 'has-error'?>">
                               <label for="jk">Jenis Kelamin</label><br>
                               <select name="jk" id="jk" class="form-control">
                                   <option value="">-- Silahkan Pilih Jenis Kelamin --</option>
                                   <option value="L" <?php echo $petugas['jk'] == "L" ? 'selected' : '' ?>>Laki-Laki</option>
                                   <option value="P" <?php echo $petugas['jk'] == "P" ? 'selected' : '' ?>>Perempuan</option>
                               </select>
                               <?php echo form_error('jk', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('alamat')) echo 'has-error'?>" >
                               <label for="alamat">Alamat</label>
                               <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control " placeholder="alamat"><?php echo $petugas['alamat'] ?></textarea>
                               <?php echo form_error('alamat', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('telepon')) echo 'has-error'?>">
                               <label for="telepon">Telepon</label>
                               <input type="text" id="telepon" name="telepon" class="form-control telepon " placeholder="Telepon" value="<?php echo $petugas['telepon'] ?>">
                               <?php echo form_error('telepon', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('email')) echo 'has-error'?>">
                               <label for="E-mail">E-mail</label>
                               <input type="text" id="E-mail" name="email" class="form-control E-mail " placeholder="E-mail" value="<?php echo $petugas['email'] ?>">
                               <?php echo form_error('E-mail', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('gambar')) echo 'has-error'?>">
                               <label for="gambar">Gambar</label>
                               <input type="file" id="gambar" name="gambar" class="form-control gambar " placeholder="Gambar" value="<?php echo set_value('gambar') ?>">
                               <?php echo form_error('gambar', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group">
                             <img src="<?php echo base_url('assets/img/petugas/') . $petugas['gambar'] ?>" alt="" width="200">
                           </div>
                           <div class="form-group <?php if(form_error('id_role')) echo 'has-error'?>">
                               <label for="id_role">Level</label>
                               <select name="id_role" id="id_role" class="form-control">
                                   <option value="">-- Silahkan Pilih Level ---</option>
                                   <?php foreach ($role as $row): ?>
                                       <option value="<?php echo $row['id_role'] ?>" <?php echo $petugas['id_role'] == $row['id_role'] ? 'selected' : '' ?>><?php echo $row['nama_role'] ?></option>
                                   <?php endforeach ?>
                               </select>
                               <?php echo form_error('id_role', '<small style="color:red">','</small>') ?>
                           </div>
                            <div class="form-group <?php if(form_error('id_outlet')) echo 'has-error'?>">
                               <label for="id_outlet">Outlet</label>
                               <select name="id_outlet" id="id_outlet" class="form-control">
                                   <option value="">-- Silahkan Pilih Outlet ---</option>
                                   <?php foreach ($outlet as $row): ?>
                                       <option value="<?php echo $row['id_outlet'] ?>" <?php echo $petugas['id_outlet'] == $row['id_outlet'] ? 'selected' : '' ?>><?php echo $row['nama_outlet'] ?></option>
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