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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped datatable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Faktur</th>
                                <th>Tanggal</th>
                                <th>Jatuh Tempo</th>
                                <th>Pelanggan</th>
                                <th>Umum</th>
                                <th>Kasir</th>
                                <th>Total Bayar</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($hold as $row): ?>
                                <tr>
                                    <td><?php echo $row['faktur_penjualan'] ?></td>
                                    <td><?php echo $row['tgl'] ?></td>
                                    <td><?php echo $row['tgl_jatuh_tempo'] ?></td>
                                    <td><?php echo $row['nama_pelanggan'] ?></td>
                                    <td><?php echo $row['pelanggan_umum'] ?></td>
                                    <td><?php echo $row['nama_karyawan'] ?></td>
                                    <td><?php echo "Rp. " . number_format($row['total_bayar']) ?></td>
                                    <td>
                                        <a href="<?php echo base_url('penjualan/invoice/') . $row['faktur_penjualan'] ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo base_url('penjualan/ubah/') . $row['faktur_penjualan'] . '?hold=true' ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo base_url('penjualan/tambah_pembayaran/') . $row['faktur_penjualan'] ?>" class="btn btn-primary"><i class="fa fa-dollar"></i></a>
                                        <a data-href="<?php echo base_url('penjualan/hapus_penjualan/') . $row['faktur_penjualan'] ?>" class="btn btn-danger hapus_penjualan"><i class="fa fa-trash"></i></a>
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