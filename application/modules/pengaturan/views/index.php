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
                <li class="active"><a href="#umum" data-toggle="tab" aria-expanded="false">Umum</a></li>
                <li class=""><a href="#printer" data-toggle="tab" aria-expanded="true">Printer</a></li>
                <li class=""><a href="#smtp" data-toggle="tab" aria-expanded="false">SMTP</a></li>
                <li class=""><a href="#hapus" data-toggle="tab" aria-expanded="false">Hapus Riwayat Otomatis</a></li>
                <li class=""><a href="#kunci" data-toggle="tab" aria-expanded="false">Kunci Penjualan</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="umum">
                  <div class="row">
                    <div class="col-md-6">
                      <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                          <img src="<?php echo base_url('assets/img/pengaturan/') . $pengaturan['logo'] ?>" width="200">
                        </div>
                        <div class="form-group <?php if(form_error('logo')) echo 'has-error'?>">
                         <label for="logo">Logo</label>
                         <input type="file" id="logo" name="logo" class="form-control logo " placeholder="Logo" value="<?php echo $pengaturan['logo'] ?>">
                         <?php echo form_error('logo', '<small style="color:red">','</small>') ?>
                       </div>   
                       <div class="form-group <?php if(form_error('multi_outlet')) echo 'has-error'?>">
                         <label for="multi_outlet">Multi Outlet</label>
                         <select name="multi_outlet" id="multi_outlet" class="form-control">
                           <option value="1" <?php echo $pengaturan['multi_outlet'] == 1 ? 'selected' : '' ?>>IYA</option>
                           <option value="0" <?php echo $pengaturan['multi_outlet'] == 0 ? 'selected' : '' ?>>TIDAK</option>
                         </select>
                         <?php echo form_error('multi_outlet', '<small style="color:red">','</small>') ?>
                       </div>
                       <div class="form-group <?php if(form_error('keterangan_invoice')) echo 'has-error'?>">
                         <label for="keterangan_invoice">Keterangan Faktur</label>
                         <textarea name="keterangan_invoice" id="keterangan_invoice" cols="30" rows="5" class="form-control" placeholder="Keterangan Faktur"><?php echo $pengaturan['keterangan_invoice'] ?></textarea>
                         <?php echo form_error('keterangan_invoice', '<small style="color:red">','</small>') ?>
                       </div>
                       <div class="form-group <?php if(form_error('peringatan_stok')) echo 'has-error'?>">
                         <label for="peringatan_stok">Peringatan Stok Tipis</label>
                         <input type="text" id="peringatan_stok" name="peringatan_stok" class="form-control peringatan_stok " placeholder="Peringatan Stok Tipis" value="<?php echo $pengaturan['peringatan_stok'] ?>">
                         <?php echo form_error('peringatan_stok', '<small style="color:red">','</small>') ?>
                       </div>
                       <div class="form-group <?php if(form_error('tampilkan_pendapatan_dashboard')) echo 'has-error'?>">
                         <label for="tampilkan_pendapatan_dashboard">Tampilkan Pendapatan Pada Dashboard</label>
                         <select name="tampilkan_pendapatan_dashboard" id="tampilkan_pendapatan_dashboard" class="form-control">
                           <option value="1" <?php echo $pengaturan['tampilkan_pendapatan_dashboard'] == 1 ? 'selected' : '' ?>>IYA</option>
                           <option value="0" <?php echo $pengaturan['tampilkan_pendapatan_dashboard'] == 0 ? 'selected' : '' ?>>TIDAK</option>
                         </select>
                         <?php echo form_error('tampilkan_pendapatan_dashboard', '<small style="color:red">','</small>') ?>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="tab-pane" id="printer">
                  <div class="row">
                    <div class="col-md-6">
                    <img src="<?= base_url('assets/img/share_printer.png') ?>" alt="" class="img-fluid">
                      <div class="form-group mt-3 <?php if(form_error('nama_printer')) echo 'has-error'?>">
                       <label for="nama_printer">Nama Printer (Sharing) * <small>tidak bolehh mengandung spasi</small></label>
                       <input type="text" id="nama_printer" name="nama_printer" class="form-control nama_printer " placeholder="Nama Printer (Sharing)" value="<?php echo $pengaturan['nama_printer'] ?>">
                       <?php echo form_error('nama_printer', '<small style="color:red">','</small>') ?>
                     </div>
                     <div class="form-group <?php if(form_error('print_otomatis')) echo 'has-error'?>">
                       <label for="print_otomatis">Print Otomatis</label>
                       <select name="print_otomatis" id="print_otomatis" class="form-control">
                         <option value="1" <?php echo $pengaturan['print_otomatis'] == 1 ? 'selected' : '' ?>>IYA</option>
                         <option value="2" <?php echo $pengaturan['print_otomatis'] == 2 ? 'selected' : '' ?>>TIDAK</option>
                       </select>
                       <?php echo form_error('print_otomatis', '<small style="color:red">','</small>') ?>
                     </div>
                   </div>
                 </div>
               </div>
               <div class="tab-pane" id="smtp">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group <?php if(form_error('smtp_host')) echo 'has-error'?>">
                     <label for="smtp_host">SMTP Host</label>
                     <input type="text" id="smtp_host" name="smtp_host" class="form-control smtp_host " placeholder="SMTP Host" value="<?php echo $pengaturan['smtp_host'] ?>">
                     <?php echo form_error('smtp_host', '<small style="color:red">','</small>') ?>
                   </div>
                   <div class="form-group <?php if(form_error('smtp_port')) echo 'has-error'?>">
                     <label for="smtp_port">SMTP Port</label>
                     <input type="number" id="smtp_port" name="smtp_port" class="form-control smtp_port " placeholder="SMTP Port" value="<?php echo $pengaturan['smtp_port'] ?>">
                     <?php echo form_error('smtp_port', '<small style="color:red">','</small>') ?>
                   </div>
                   <div class="form-group <?php if(form_error('smtp_email')) echo 'has-error'?>">
                     <label for="smtp_email">SMTP Email</label>
                     <input type="text" id="smtp_email" name="smtp_email" class="form-control smtp_email " placeholder="SMTP Email" value="<?php echo $pengaturan['smtp_email'] ?>">
                     <?php echo form_error('smtp_email', '<small style="color:red">','</small>') ?>
                   </div>
                   <div class="form-group <?php if(form_error('smtp_username')) echo 'has-error'?>">
                     <label for="smtp_username">SMTP Username</label>
                     <input type="text" id="smtp_username" name="smtp_username" class="form-control smtp_username " placeholder="SMTP Username" value="<?php echo $pengaturan['smtp_username'] ?>">
                     <?php echo form_error('smtp_username', '<small style="color:red">','</small>') ?>
                   </div>
                   <div class="form-group <?php if(form_error('smtp_password')) echo 'has-error'?>">
                     <label for="smtp_password">SMTP Password</label>
                     <input type="text" id="smtp_password" name="smtp_password" class="form-control smtp_password " placeholder="SMTP Password" value="<?php echo $pengaturan['smtp_password'] ?>">
                     <?php echo form_error('smtp_password', '<small style="color:red">','</small>') ?>
                   </div>
                 </div>
               </div>
             </div>
             <div class="tab-pane" id="hapus">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group <?php if(form_error('hapus_riwayat_penjualan_otomatis')) echo 'has-error'?>">
                   <label for="hapus_riwayat_penjualan_otomatis">Hapus Riwayat Penjualan Otomatis</label>
                   <select name="hapus_riwayat_penjualan_otomatis" id="hapus_riwayat_penjualan_otomatis" class="form-control">
                     <option value="1" <?php echo $pengaturan['hapus_riwayat_penjualan_otomatis'] == 1 ? 'selected' : '' ?>>YA</option>
                     <option value="0" <?php echo $pengaturan['hapus_riwayat_penjualan_otomatis'] == 0 ? 'selected' : '' ?>>TIDAK</option>
                   </select>
                   <?php echo form_error('hapus_riwayat_penjualan_otomatis', '<small style="color:red">','</small>') ?>
                 </div>
                 <div class="form-group <?php if(form_error('lama_hari_penjualan')) echo 'has-error'?>">
                   <label for="lama_hari_penjualan">Hapus Setelah Hari</label>
                   <select name="lama_hari_penjualan" id="lama_hari_penjualan" class="form-control">
                     <option value="1" <?php echo $pengaturan['lama_hari_penjualan'] == '1' ? 'selected' : '' ?>>1 Hari</option>
                     <option value="7" <?php echo $pengaturan['lama_hari_penjualan'] == '7' ? 'selected' : '' ?>>1 Minggu</option>
                     <option value="30" <?php echo $pengaturan['lama_hari_penjualan'] == '30' ? 'selected' : '' ?>>1 Bulan</option>
                     <option value="360" <?php echo $pengaturan['lama_hari_penjualan'] == '360' ? 'selected' : '' ?>>1 Tahun</option>
                     <option value="Sesuaikan" <?php echo $pengaturan['lama_hari_penjualan'] == 'Sesuaikan' ? 'selected' : '' ?>>Sesuaikan</option>
                   </select>
                   <?php echo form_error('lama_hari_penjualan', '<small style="color:red">','</small>') ?>
                 </div>
                 <div class="form-group <?php if(form_error('sesuaikan_hari_penjualan')) echo 'has-error'?>">
                   <label for="sesuaikan_hari_penjualan">Sesuaikan</label>
                   <input type="sesuaikan_hari_penjualan" id="sesuaikan_hari_penjualan" name="sesuaikan_hari_penjualan" class="form-control sesuaikan_hari_penjualan " placeholder="Sesuaikan" value="<?php echo $pengaturan['sesuaikan_hari_penjualan'] ?>">
                   <?php echo form_error('sesuaikan_hari_penjualan', '<small style="color:red">','</small>') ?>
                 </div>
                 <div class="form-group <?php if(form_error('hapus_riwayat_pembelian_otomatis')) echo 'has-error'?>">
                   <label for="hapus_riwayat_pembelian_otomatis">Hapus Riwayat pembelian Otomatis</label>
                   <select name="hapus_riwayat_pembelian_otomatis" id="hapus_riwayat_pembelian_otomatis" class="form-control">
                     <option value="1" <?php echo $pengaturan['hapus_riwayat_pembelian_otomatis'] == 1 ? 'selected' : '' ?>>YA</option>
                     <option value="0" <?php echo $pengaturan['hapus_riwayat_pembelian_otomatis'] == 0 ? 'selected' : '' ?>>TIDAK</option>
                   </select>
                   <?php echo form_error('hapus_riwayat_pembelian_otomatis', '<small style="color:red">','</small>') ?>
                 </div>
                 <div class="form-group <?php if(form_error('lama_hari_pembelian')) echo 'has-error'?>">
                   <label for="lama_hari_pembelian">Hapus Setelah Hari</label>
                   <select name="lama_hari_pembelian" id="lama_hari_pembelian" class="form-control">
                     <option value="1" <?php echo $pengaturan['lama_hari_pembelian'] == '1' ? 'selected' : '' ?>>1 Hari</option>
                     <option value="7" <?php echo $pengaturan['lama_hari_pembelian'] == '7' ? 'selected' : '' ?>>1 Minggu</option>
                     <option value="30" <?php echo $pengaturan['lama_hari_pembelian'] == '30' ? 'selected' : '' ?>>1 Bulan</option>
                     <option value="360" <?php echo $pengaturan['lama_hari_pembelian'] == '360' ? 'selected' : '' ?>>1 Tahun</option>
                     <option value="Sesuaikan" <?php echo $pengaturan['lama_hari_pembelian'] == 'Sesuaikan' ? 'selected' : '' ?>>Sesuaikan</option>
                   </select>
                   <?php echo form_error('lama_hari_pembelian', '<small style="color:red">','</small>') ?>
                 </div>
                 <div class="form-group <?php if(form_error('sesuaikan_hari_pembelian')) echo 'has-error'?>">
                   <label for="sesuaikan_hari_pembelian">Sesuaikan</label>
                   <input type="sesuaikan_hari_pembelian" id="sesuaikan_hari_pembelian" name="sesuaikan_hari_pembelian" class="form-control sesuaikan_hari_pembelian " placeholder="Sesuaikan" value="<?php echo $pengaturan['sesuaikan_hari_pembelian'] ?>">
                   <?php echo form_error('sesuaikan_hari_pembelian', '<small style="color:red">','</small>') ?>
                 </div>
               </div>
             </div>
           </div>
           <div class="tab-pane" id="kunci">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group <?php if(form_error('kunci_penjualan')) echo 'has-error'?>">
                 <label for="kunci_penjualan">Kunci Tombol Ubah Dan Hapus (Penjualan)</label>
                 <select name="kunci_penjualan" id="kunci_penjualan" class="form-control">
                   <option value="1" <?php echo $pengaturan['kunci_penjualan'] == 1 ? 'selected' : '' ?>>YA</option>
                   <option value="0" <?php echo $pengaturan['kunci_penjualan'] == 0 ? 'selected' : '' ?>>TIDAK</option>
                 </select>
                 <?php echo form_error('kunci_penjualan', '<small style="color:red">','</small>') ?>
               </div>
               <div class="form-group <?php if(form_error('password_penjualan')) echo 'has-error'?>">
                 <label for="password_penjualan">Password Penjualan</label>
                 <input type="text" id="password_penjualan" name="password_penjualan" class="form-control password_penjualan " placeholder="Password Penjualan" value="<?php echo $pengaturan['password_penjualan'] ?>">
                 <?php echo form_error('password_penjualan', '<small style="color:red">','</small>') ?>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
     <div class="box-footer">
       <div class="form-group">
         <button type="submit" class="btn btn-primary btn-block">Submit</button>
       </form>
     </div>
   </div>
 </div>
</div>
