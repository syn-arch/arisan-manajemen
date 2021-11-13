<style>
  .pembelian-item {
    display:block;
    height:450px;
    overflow:auto;
  }
  .thead-item, .pembelian-item tr {
    display:table;
    width:100%;
    table-layout:fixed;/* even columns width , fix width of table too*/
  }
  thead {
    width: calc( 100% - 1em )/* scrollbar is average 1em/16px width, remove it from thead width */
  }
  table {
    width:400px;
  }
  .font_small {
    font-size: 14px;
  }
</style>

<form action="<?php echo base_url('pembelian/proses_update') ?>" method="POST" class="form-pembelian" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-5">
      <div class="box box-danger">
        <div class="box-header with-border">
          <div class="pull-left">
           Tanggal : <?php echo date('d-m-Y') ?>
         </div>
         <div class="pull-right">
           Kasir : <?php echo $this->session->userdata('nama_petugas'); ?>
         </div>
       </div>
       <div class="box-body">
        <input type="hidden" name="id_petugas" value="<?php echo $this->session->userdata('id_petugas'); ?>">
        <input type="hidden" name="faktur_pembelian" value="<?php echo $pembelian['faktur_pembelian'] ?>">
        <div class="form-group">
          <select name="id_supplier" id="id_supplier" class="form-control select2 supplier">
            <?php foreach ($supplier as $row): ?>
              <option <?php echo $row['id_supplier'] == $pembelian['id_supplier'] ? 'selected' : '' ?> value="<?php echo $row['id_supplier'] ?>"><?php echo $row['nama_supplier'] ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <div class="form-group <?php if(form_error('barcode')) echo 'has-error'?>">
                <input type="text" id="barcode" name="barcode" class="form-control barcode" placeholder="Barcode" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <input type="text" class="form-control qty_brg qty_focus" placeholder="Qty">
          </div>
        </div>
        <div class="form-group table-responsive">
          <table class="table">
            <thead class="thead-item">
              <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th><i class="fa fa-gear"></i></th>
              </tr>
            </thead>
            <tbody class="pembelian-item">
              <?php foreach ($detail_pembelian as $row): ?>
                <?php $brg = $this->db->get_where('barang', ['id_barang' => $row['id_barang']])->row_array(); ?>
                <tr data-id="<?php echo $row['id_barang'] ?>">
                  <input type="hidden" name="id_barang[]" value="<?php echo $row['id_barang'] ?>">
                  <td><?php echo $row['nama_pendek'] ?></td>
                  <td><input class="form-control harga_pokok" name="harga_pokok[]" autocomplete="off" data-id="<?php echo $row['id_barang'] ?>" type="text" value="<?php echo $row['harga_pokok'] ?>"></td>
                  <td><input class="form-control qty" step="0.1" autocomplete="off" name="jumlah[]" data-id="<?php echo $row['id_barang'] ?>" data-harga="<?php echo $row['harga_pokok'] ?>" type="number" value="<?php echo $row['jumlah'] ?>" style="width: 5em"></td>
                  <td class="subtotal" data-kode="<?php echo $row['id_barang'] ?>"><?php echo number_format($row['total_harga']) ?></td>
                  <td>
                    <a class="btn btn-danger btn-flat hapus-barang btn-block" data-id="<?php echo $row['id_barang'] ?>" data-harga="<?php echo $row['harga_pokok'] ?>"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
                <tr style="display: block;" data-id="<?php echo $row['id_barang'] ?>">
                  <td><input type="text" name="golongan_1[]" class="form-control" placeholder="Golongan 1" value="<?php echo $brg['golongan_1'] ?>"></td>
                  <td><input type="text" name="golongan_2[]" class="form-control" placeholder="Golongan 2" value="<?php echo $brg['golongan_2'] ?>"></td>
                  <td><input type="text" name="golongan_3[]" class="form-control" placeholder="Golongan 3" value="<?php echo $brg['golongan_3'] ?>"></td>
                  <td><input type="text" name="golongan_4[]" class="form-control" placeholder="Golongan 4" value="<?php echo $brg['golongan_4'] ?>"></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer">
        <table class="table">
         <tr>
          <th>Total Item</th>
          <td colspan="2"><input readonly="" type="text" class="form-control total_item" name="total_item" value="<?php echo $pembelian['total_item'] ?>"></td>
        </tr>
        <tr>
          <th>Tgl Pembelian</th>
          <td><input required="" type="datetime-local" class="form-control" name="tgl_pembelian" value="<?php echo date("Y-m-d\TH:i:s", strtotime($pembelian['tgl_pembelian']))  ?>"></td>
        </tr>
        <tr>
          <th>Referensi</th>
          <td><input type="text" class="form-control" name="referensi" placeholder="Referensi" value="<?php echo $pembelian['referensi'] ?>"></td>
        </tr>
        <tr>
          <th>Total Bayar</th>
          <td><input readonly="" type="text" class="form-control jumlah_bayar" name="jumlah_bayar" value="<?php echo "Rp. " . number_format($pembelian['total_bayar']) ?>"></td>
        </tr>
        <tr>
          <td colspan="2">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Konfirmasi</button>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <button type="submit" class="btn btn-danger btn-block btn-flat batal">Batal</button>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div class="col-md-7">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-danger">
        <div class="box-header with-border">
          <div class="pull-left">
            <?php echo faktur_no(true) ?>
          </div>
          <div class="pull-right">
            <input type="text" class="jumlah_bayar" style="text-align: right;border:none; font-size: 30px" value="Rp. 0">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-danger">
        <div class="box-header with-border">
          <div class="pull-left">
            <h4>Data Barang</h4>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table" id="table-cari-barang" width="100%">
                  <thead>
                    <tr>
                      <th>Kode Barang</th>
                      <th>Nama Barang</th>
                      <th>Satuan</th>
                      <th>Stok</th>
                      <th>Harga Pokok</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

</form>

<script>
  <?php 

  echo "const judul = " . "'$judul';";
  $t = $pembelian['total_bayar'];
  echo "const total_bayar_rp = " . $t;

  ?>
</script>