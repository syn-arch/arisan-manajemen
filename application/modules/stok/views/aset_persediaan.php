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
            <a href="<?php echo base_url('stok/export_aset_persediaan') ?>" class="btn btn-success"><i class="fa fa-sign-out"></i> Export</a>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table datatable" id="table-stok-outlet" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Stok</th>
                  <th>Harga Pokok</th>
                  <th>Aset</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($laporan as $row): ?>
                  <tr>
                    <td><?php echo $row['id_barang'] ?></td>
                    <td><?php echo $row['nama_barang'] ?></td>
                    <td><?php echo $row['stok'] ?></td>
                    <td><?php echo "Rp." . number_format($row['harga_pokok']) ?></td>
                    <td><?php echo "Rp." . number_format($row['harga_pokok'] * $row['stok']) ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody> 
              <tfoot>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <th>Total Aset</th>
                  <th><?php echo "Rp." . number_format($total) ?></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>    