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
                        <a href="<?php echo base_url('petugas/tambah_akses') ?>" class="btn btn-danger"><i class="fa fa-plus"></i> Tambah Data</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped datatable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Role</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $num = 1; foreach ($role as $row): ?>
                                <tr>
                                    <td><?php echo $num++ ?></td>
                                    <td><?php echo $row['nama_role'] ?></td>
                                    <td>
                                        <a title="ubah" href="<?php echo base_url('petugas/ubah_akses/') . $row['id_role'] ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                        <a title="hapus" data-href="<?php echo base_url('petugas/hapus_akses/') . $row['id_role'] ?>" class="btn btn-danger hapus_role"><i class="fa fa-trash"></i></a>
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