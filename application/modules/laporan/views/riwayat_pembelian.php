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
                    <a href="javascrip:void(0)" class="btn btn-danger hapus_bulk_riwayat_pembelian"><i class="fa fa-trash"></i> Hapus</a>
                    <a href="<?php echo base_url('laporan/export_riwayat_pembelian') ?>" class="btn btn-success"><i class="fa fa-sign-in"></i> Export Excel</a>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" cellspacing="0" width="100%" id="table-riwayat-pembelian">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="hapus_riwayat_pembelian" id="hapus_riwayat_pembelian" class="check_all"></th>
                                <th>Faktur</th>
                                <th>Tanggal</th>
                                <th>Jatuh Tempo</th>
                                <th>Supplier</th>
                                <th>Petugas</th>
                                <th>Total Bayar</th>
                                <th>Cash</th>
                                <th>Sisa Bayar</th>
                                <th>Status</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>