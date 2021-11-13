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
                        <a href="<?php echo base_url('master/agen') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group <?php if(form_error('id_agen')) echo 'has-error'?>">
                                <label for="id_agen">ID Agen</label>
                                <input readonly="" type="text" id="id_agen" name="id_agen" class="form-control" value="<?php echo $agen['id_agen'] ?>">
                                <?php echo form_error('id_agen', '<small style="color:red">','</small>') ?>
                            </div>
                            <div class="form-group <?php if(form_error('nama_agen')) echo 'has-error'?>">
                                <label for="nama_agen">Nama Agen</label>
                                <input type="text" id="nama_agen" name="nama_agen" class="form-control nama_agen" placeholder="Nama agen" value="<?php echo $agen['nama_agen'] ?>">
                                <?php echo form_error('nama_agen', '<small style="color:red">','</small>') ?>
                            </div>
                            <div class="form-group <?php if(form_error('alamat')) echo 'has-error'?>">
                               <label for="alamat">Alamat</label>
                               <input type="text" id="alamat" name="alamat" class="form-control alamat " placeholder="alamat" value="<?php echo $agen['alamat'] ?>">
                               <?php echo form_error('alamat', '<small style="color:red">','</small>') ?>
                           </div>
                           <div class="form-group <?php if(form_error('telepon')) echo 'has-error'?>">
                               <label for="telepon">Telepon</label>
                               <input type="text" id="telepon" name="telepon" class="form-control telepon " placeholder="telepon" value="<?php echo $agen['telepon'] ?>">
                               <?php echo form_error('telepon', '<small style="color:red">','</small>') ?>
                           </div>
                            <div class="form-group">
                                <label for="">Kelompok</label>
                                <select required="" name="id_kelompok" id="id_kelompok" class="form-control select2 kelompok kelompok-wrapper">
                                    <?php foreach ($kelompok as $row): ?>
                                        <option value="<?php echo $row['id_kelompok'] ?>" <?php echo $row['id_kelompok'] == $agen['id_kelompok'] ? 'selected' : '' ?>>
                                            <?php echo $row['nama_kelompok'] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group <?php if(form_error('nominal_kocokan')) echo 'has-error'?>" >
                             <label for="nominal_kocokan">Nominal Kocokan</label>
                             <input name="nominal_kocokan" id="nominal_kocokan" class="form-control " placeholder="nominal_kocokan" value="<?php echo $agen['nominal_kocokan'] ?>">
                             <?php echo form_error('nominal_kocokan', '<small style="color:red">','</small>') ?>
                         </div>
                         <div class="form-group <?php if(form_error('periode_arisan')) echo 'has-error'?>">
                             <label for="periode_arisan">Periode Arisan</label>
                             <input type="text" id="periode_arisan" name="periode_arisan" class="form-control periode_arisan " placeholder="periode_arisan" value="<?php echo $agen['periode_arisan'] ?>">
                             <?php echo form_error('periode_arisan', '<small style="color:red">','</small>') ?>
                         </div>
                         <div class="form-group <?php if(form_error('keterangan')) echo 'has-error'?>">
                             <label for="keterangan">Keterangan</label>
                             <input type="text" id="keterangan" name="keterangan" class="form-control keterangan " placeholder="keterangan" value="<?php echo $agen['keterangan'] ?>">
                             <?php echo form_error('keterangan', '<small style="color:red">','</small>') ?>
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