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
                    <a href="javascrip:void(0)" class="btn btn-danger hapus_bulk_riwayat_penjualan"><i class="fa fa-trash"></i> Hapus</a>
                    <a href="<?php echo base_url('laporan/export_riwayat_penjualan') ?>" class="btn btn-success"><i class="fa fa-sign-in"></i> Export Excel</a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form action="">
                            <div class="form-group">
                                <label for="">Dari Tanggal</label>
                                <input type="date" name="dari" id="dari" class="form-control" value="<?php echo date('Y-m-d') ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Sampai Tanggal</label>
                                <input type="date" name="sampai" id="sampai" class="form-control" value="<?php echo date('Y-m-d') ?>">
                            </div>
                            <div class="form-group <?php if(form_error('id_outlet')) echo 'has-error'?>">
                                <label for="id_outlet">Outlet</label>
                                <select name="id_outlet" id="id_outlet" class="form-control">
                                    <option value="">Semua Outlet</option>
                                    <?php foreach ($outlet as $row): ?>
                                        <option value="<?php echo $row['id_outlet'] ?>"><?php echo $row['nama_outlet'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <?php echo form_error('id_outlet', '<small style="color:red">','</small>') ?>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <br><br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" cellspacing="0" width="100%" id="table-riwayat-penjualan">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="hapus_riwayat_penjualan" id="hapus_riwayat_penjualan" class="check_all"></th>
                                <th>Faktur</th>
                                <th>Tanggal</th>
                                <th>Jatuh Tempo</th>
                                <th>Pelanggan</th>
                                <th>Kelompok</th>
                                <th>Kasir</th>
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

<script>
    const dari = '<?php echo $this->input->get('dari') ?>'
    const sampai = '<?php echo $this->input->get('sampai') ?>'
    const id_outlet = '<?php echo $this->input->get('id_outlet') ?>'
    const level = '<?php echo $this->session->userdata('level') ?>'
</script>