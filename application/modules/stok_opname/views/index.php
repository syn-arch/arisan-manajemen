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
                         <a href="<?php echo base_url('stok_opname/export') ?>" class="btn btn-success"><i class="fa fa-sign-in"></i> Export Excel</a>
                        <a href="<?php echo base_url('stok_opname/tambah_stok_opname?id_outlet=' . $outlet['id_outlet']) ?>" class="btn btn-danger"><i class="fa fa-plus"></i> Tambah Data</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped datatable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Kode SO</th>
                                <th>Tanggal</th>
                                <th>Petugas</th>
                                <th>Outlet</th>
                                <th>Keterangan</th>
                                <th>Total Kerugian</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach ($stok_opname as $row): ?>
                                <tr>
                                    <td><?php echo $row['id_stok_opname'] ?></td>
                                    <td><?php echo $row['tgl'] ?></td>
                                    <td><?php echo $row['nama_petugas'] ?></td>
                                    <td><?php echo $row['nama_outlet'] ?></td>
                                    <td><?php echo $row['keterangan'] ?></td>
                                    <td><?php echo "Rp. " . number_format($row['total_kerugian']) ?></td>
                                    <td>
                                        <a title="ubah" href="<?php echo base_url('stok_opname/ubah/' . $row['id_stok_opname']) . '?id_outlet=' . $row['id_outlet'] ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                        <a title="export" href="<?php echo base_url('stok_opname/export_excel/' . $row['id_stok_opname']) ?>" class="btn btn-info"><i class="fa fa-sign-out"></i></a>
                                        <a title="hapus" data-href="<?php echo base_url('stok_opname/hapus/' . $row['id_stok_opname']) ?>" class="btn btn-danger hapus_stok_opname"><i class="fa fa-trash"></i></a>
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
