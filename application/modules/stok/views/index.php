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
                         <a href="<?php echo base_url('stok/export') ?>" class="btn btn-success"><i class="fa fa-sign-in"></i> Export Excel</a>
                        <a href="<?php echo base_url('stok/tambah_stok') ?>" class="btn btn-danger"><i class="fa fa-plus"></i> Tambah Data</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" cellspacing="0" width="100%" id="table-stok">
                        <thead>
                            <tr>
                                <th>Kode Stok</th>
                                <th>Tanggal</th>
                                <th>Petugas</th>
                                <th>Dari</th>
                                <th>Ke</th>
                                <th>Keterangan</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                    </table>
                    <small>* Jika Dari sama dengan kosong maka artinya stok dikirim dari gudang</small>
                </div>
            </div>
        </div>
    </div>
</div>