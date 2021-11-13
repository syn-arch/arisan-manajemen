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
                        <a href="<?php echo base_url('master/export_karyawan') ?>" class="btn btn-success"><i class="fa fa-sign-in"></i> Export Excel</a>
                        <a href="#import-karyawan" data-toggle="modal" class="btn btn-info"><i class="fa fa-sign-out"></i> Import Excel</a>
                        <a href="<?php echo base_url('master/tambah_karyawan') ?>" class="btn btn-danger"><i class="fa fa-plus"></i> Tambah Data</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" cellspacing="0" width="100%" id="table-karyawan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Outlet</th>
                                <th>Nama karyawan</th>
                                <th>Alamat</th>
                                <th>Jenis Kelamin</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Jabatan</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="import-karyawan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      <h4 class="modal-title" id="exampleModalLongTitle">Import karyawan</h4>
  </div>
  <div class="modal-body">
    <strong>Cara import</strong>
    <p>Download template dibawah ini kemudian isi dengan data karyawan, kemudian import kembali pada form dibawah ini</p>
    <a href="<?php echo base_url('master/template_karyawan') ?>" class="btn btn-primary"><i class="fa fa-download"></i> Download Template</a>
    <hr>
    <form action="<?php echo base_url('master/import_karyawan') ?>" method="POST" enctype="multipart/form-data">
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

