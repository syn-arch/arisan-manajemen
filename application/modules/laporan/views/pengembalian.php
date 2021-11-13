<div class="box box-danger">
    <div class="box-header with-border">
        <div class="pull-left">
            <h4 class="box-title"><?php echo $judul ?></h4>
        </div>
        <div class="pull-right">
            <a href="<?php echo base_url('laporan/export_pengembalian') ?>" class="btn btn-success"><i class="fa fa-sign-in"></i> Export Excel</a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Barcode</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $no=1; foreach ($laporan as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['id_barang'] ?></td>
                                <td><?= $row['barcode'] ?></td>
                                <td><?= $row['nama_barang'] ?></td>
                                <td><?= "Rp. " . number_format($row['harga_pokok']) ?></td>
                                <td><?= $row['barang_kembali'] ?></td>
                                <td><?= "Rp. " . number_format($row['total']) ?></td>
                            </tr>
                        <?php endforeach ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Total pengembalian</th>
                            <th><?= "Rp. " . number_format($total_pengembalian) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
</div>