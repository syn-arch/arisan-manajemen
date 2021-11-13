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
       <p>
         Silahkan klik tombol dibawah untuk membackup file database aplikasi yang nantinya akan dibutuhkan ketika akan melakukan restore
       </p>
       <a href="<?php echo base_url('utilitas/backup_db') ?>" class="btn btn-danger"><i class="fa fa-download"></i> Backup Database</a>
     </div>
   </div>
 </div>
</div>

 <div class="row">
    <div class="col-xs-12">
        <div class="box box-danger">
            <div class="box-body">
               <div class="table-responsive">
                   <table class="table datatable">
                       <thead>
                           <tr>
                               <th>No</th>
                               <th>Tanggal</th>
                               <th>Nama File</th>
                               <th><i class="fa fa-gears"></i></th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php $i=1; foreach ($db as $row): ?>
                               <tr>
                                   <td><?php echo $i++ ?></td>
                                   <td><?php echo $row['tgl'] ?></td>
                                   <td><?php echo $row['file'] ?></td>
                                   <td>
                                       <a href="<?php echo base_url('utilitas/download_db/') . $row['file']  ?>" class="btn btn-info"><i class="fa fa-download"></i> Download</a>
                                       <a href="<?php echo base_url('utilitas/restore_db/') . $row['file'] ?>" class="btn btn-warning"><i class="fa fa-download"></i> Restore</a>
                                       <a data-href="<?php echo base_url('utilitas/hapus/') . $row['id_backup'] ?>" class="btn btn-danger hapus_backup"><i class="fa fa-trash"></i> Hapus</a>
                                   </td>
                               </tr>
                           <?php endforeach ?>
                       </tbody>
                   </table>
               </div>
            </div>
        </div>
    </div>
</div>