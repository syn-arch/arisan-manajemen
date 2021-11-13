<div class="row">
    <div class="col-xs-12">
        <div class="box box-danger">
            <div class="box-header with-border">
                <div class="pull-left">
                    <div class="box-title">
                        <h4><?php echo $judul ?></h4>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="false">Ubah Profil</a></li>
                          <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="true">Ubah Gambar</a></li>
                          <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">Ubah Password</a></li>
                      </ul>
                      <div class="tab-content">
                          <div class="tab-pane active" id="activity">
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="<?php echo base_url('profil/ubah_profil_action') ?>" method="POST">
                                        <div class="form-group <?php if(form_error('id_petugas')) echo 'has-error'?>">
                                          <label for="id_petugas">ID Petugas</label>
                                          <input readonly="" type="text" id="id_petugas" name="id_petugas" class="form-control" value="<?php echo $profil['id_petugas'] ?>">
                                          <?php echo form_error('id_petugas', '<small style="color:red">','</small>') ?>
                                      </div>
                                      <div class="form-group <?php if(form_error('nama_petugas')) echo 'has-error'?>">
                                         <label for="nama_petugas">Nama Petugas</label>
                                         <input type="text" id="nama_petugas" name="nama_petugas" class="form-control nama_petugas" placeholder="Nama Petugas" value="<?php echo $profil['nama_petugas'] ?>">
                                         <?php echo form_error('nama_petugas', '<small style="color:red">','</small>') ?>
                                     </div>
                                     <div class="form-group <?php if(form_error('jk')) echo 'has-error'?>">
                                         <label for="jk">Jenis Kelamin</label><br>
                                         <select name="jk" id="jk" class="form-control">
                                             <option value="">-- Silahkan Pilih Jenis Kelamin --</option>
                                             <option value="L" <?php echo $profil['jk'] == "L" ? 'selected' : '' ?>>Laki-Laki</option>
                                             <option value="P" <?php echo $profil['jk'] == "P" ? 'selected' : '' ?>>Perempuan</option>
                                         </select>
                                         <?php echo form_error('jk', '<small style="color:red">','</small>') ?>
                                     </div>
                                     <div class="form-group <?php if(form_error('alamat')) echo 'has-error'?>" >
                                         <label for="alamat">Alamat</label>
                                         <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control " placeholder="alamat"><?php echo $profil['alamat'] ?></textarea>
                                         <?php echo form_error('alamat', '<small style="color:red">','</small>') ?>
                                     </div>
                                     <div class="form-group <?php if(form_error('telepon')) echo 'has-error'?>">
                                         <label for="telepon">Telepon</label>
                                         <input type="text" id="telepon" name="telepon" class="form-control telepon " placeholder="Telepon" value="<?php echo $profil['telepon'] ?>">
                                         <?php echo form_error('telepon', '<small style="color:red">','</small>') ?>
                                     </div>
                                     <div class="form-group <?php if(form_error('email')) echo 'has-error'?>">
                                         <label for="E-mail">E-mail</label>
                                         <input type="text" id="E-mail" name="email" class="form-control E-mail " placeholder="E-mail" value="<?php echo $profil['email'] ?>">
                                         <?php echo form_error('E-mail', '<small style="color:red">','</small>') ?>
                                     </div>
                                     <div class="form-group">
                                         <button type="submit" class="btn btn-danger btn-block">Submit</button>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                     <div class="tab-pane" id="timeline">
                        <div class="row">
                            <div class="col-md-6">
                                <form method="POST" action="<?php echo base_url('profil/ubah_gambar_action') ?>" enctype="multipart/form-data">
                                    <img src="<?php echo base_url('assets/img/petugas/') . $profil['gambar'] ?>" alt="" class="img-responsive" width="200">
                                    <div class="form-group <?php if(form_error('gambar')) echo 'has-error'?>">
                                        <label for="gambar">Gambar</label>
                                        <input required="" type="file" id="gambar" name="gambar" class="form-control gambar " placeholder="Gambar" value="<?php echo set_value('gambar') ?>">
                                        <?php echo form_error('gambar', '<small style="color:red">','</small>') ?>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger btn-block">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="settings">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="<?php echo base_url('profil/ubah_password_action') ?>" method="POSt">
                                    <div class="form-group <?php if(form_error('pw_sekarang')) echo 'has-error'?>">
                                        <label for="pw_sekarang">Password saat ini</label>
                                        <input type="password" id="pw_sekarang" name="pw_sekarang" class="form-control pw_sekarang " placeholder="Password saat ini" value="<?php echo set_value('pw_sekarang') ?>">
                                        <?php echo form_error('pw_sekarang', '<small style="color:red">','</small>') ?>
                                    </div>
                                    <div class="form-group <?php if(form_error('pw1')) echo 'has-error'?>">
                                        <label for="pw1">Password Baru</label>
                                        <input type="password" id="pw1" name="pw1" class="form-control pw1 " placeholder="Password Baru" value="<?php echo set_value('pw1') ?>">
                                        <?php echo form_error('pw1', '<small style="color:red">','</small>') ?>
                                    </div>
                                    <div class="form-group <?php if(form_error('pw2')) echo 'has-error'?>">
                                        <label for="pw2">Konfirmasi Password Baru</label>
                                        <input type="password" id="pw2" name="pw2" class="form-control pw2 " placeholder="Konfirmasi Password Baru" value="<?php echo set_value('pw2') ?>">
                                        <?php echo form_error('pw2', '<small style="color:red">','</small>') ?>
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
    </div>