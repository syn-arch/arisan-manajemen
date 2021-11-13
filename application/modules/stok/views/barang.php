<?php if ($id_outlet = $this->input->get('id_outlet')): ?>
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
            <a href="<?php echo base_url('stok/export_stok_outlet/' . $id_outlet) ?>" class="btn btn-success"><i class="fa fa-sign-out"></i> Export</a>
            <a href="#import-stok" data-toggle="modal" class="btn btn-info"><i class="fa fa-sign-in"></i> Import</a>
            <?php if (!$this->session->userdata('id_outlet')): ?>
            <a href="<?php echo base_url('stok/barang') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
            <?php endif ?>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table" id="table-stok-outlet" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Stok</th>
                  <th><i class="fa fa-gears"></i></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>    
  <?php else : ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-danger">
          <div class="box-header with-border">
            <div class="pull-left">
              <div class="box-title">
                <h4>Pilih Outlet</h4>
              </div>
            </div>
          </div>
          <div class="box-body">
           <form>
             <div class="form-group <?php if(form_error('id_outlet')) echo 'has-error'?>">
               <label for="id_outlet">Outlet</label>
               <select name="id_outlet" id="id_outlet" class="form-control">
                 <option value="">-- Pilih Outlet --</option>
                 <?php foreach ($outlet as $row): ?>
                   <option value="<?php echo $row['id_outlet'] ?>"><?php echo $row['nama_outlet'] ?></option>
                 <?php endforeach ?>
               </select>
               <?php echo form_error('id_outlet', '<small style="color:red">','</small>') ?>
             </div>
             <div class="form-group">
               <button type="submit" class="btn btn-primary btn-block">Submit</button>
             </div>
           </form>
         </div>
       </div>
     </div>
   </div>   
 <?php endif ?>

 <div class="modal fade" id="import-stok" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="exampleModalLongTitle">Import stok</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('stok/import_stok') ?>" method="POST" enctype="multipart/form-data">
          <div class="form-group <?php if(form_error('excel')) echo 'has-error'?>">
            <label for="excel">File Excel</label>
            <input required="" type="file" id="excel" name="excel" class="form-control excel " placeholder="File Excel" value="<?php echo set_value('excel') ?>">
            <?php echo form_error('excel', '<small style="color:red">','</small>') ?>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-danger btn-block">Submit</button>
          </div>
        </div>
        <div class="modal-footer">
        </form>
      </div>
    </div>
  </div>
</div>


<script>
  const id_outlet = '<?php echo $this->input->get('id_outlet') ?>'
</script>