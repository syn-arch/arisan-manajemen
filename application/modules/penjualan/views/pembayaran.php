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
                        <a href="<?php echo base_url('penjualan/tambah_pembayaran/' . $faktur_penjualan) ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
                        <a href="<?php echo base_url('laporan/riwayat_penjualan') ?>" class="btn btn-success"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped datatable" cellspacing="0" width="100%" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Dibayar Dengan</th>
                                <th>Nominal</th>
                                <th>Kartu Kredit</th>
                                <th>Kartu Debit</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($pembayaran as $row): ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td><?php echo $row['tgl'] ?></td>
                                    <td><?php echo $row['dibayar_dengan'] ?></td>
                                    <td><?php echo "Rp. " . number_format($row['nominal']) ?></td>
                                    <td><?php echo $row['no_kredit'] ?></td>
                                    <td><?php echo $row['no_debit'] ?></td>
                                    <td>
                                        <a href="<?php echo base_url('penjualan/ubah_pembayaran/' . $row['id_pembayaran']) ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                        <a data-href="<?php echo base_url('penjualan/hapus_pembayaran/' . $row['id_pembayaran'] . '/' . $row['faktur_penjualan'] ) ?>" class="btn btn-danger hapus_pembayaran"><i class="fa fa-trash"></i></a>
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
