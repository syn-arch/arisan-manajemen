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
                        <a href="<?php echo base_url('pulsa/export') ?>" class="btn btn-success"><i class="fa fa-sign-in"></i> Export Excel</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table-pulsa" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Tanggal</th>
                                <th>Petugas</th>
                                <th>Outlet</th>
                                <th>Telepon</th>
                                <th>Saldo Awal</th>
                                <th>Harga Pulsa</th>
                                <th>Saldo Akhir</th>
                                <th>Keterangan</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-danger">
            <div class="box-header with-border">
                <div class="pull-left">
                    <div class="box-title">
                        <h4><?php echo "Riwayat Tambah Saldo" ?></h4>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table-riwayat-saldo" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Tgl</th>
                                <th>Saldo Awal</th>
                                <th>Saldo Ditambah</th>
                                <th>Saldo Akhir</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
