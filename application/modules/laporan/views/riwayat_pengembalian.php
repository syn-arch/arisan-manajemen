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
                    <a href="<?php echo base_url('laporan/export_riwayat_pengembalian') ?>" class="btn btn-success"><i class="fa fa-sign-in"></i> Export Excel</a>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" cellspacing="0" width="100%" id="table-riwayat-pengembalian">
                        <thead>
                            <tr>
                                <th>Faktur</th>
                                <th>Tanggal</th>
                                <th>Outlet</th>
                                <th>Pelanggan</th>
                                <th>Kasir</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tfoot>
                                <th>Total Kerugian</th>
                                <th><?php echo "Rp. " . number_format($total_kerugian) ?></th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>