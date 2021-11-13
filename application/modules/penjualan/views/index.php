<style>
  .penjualan-item {
    display:block;
    height:350px;
    overflow:auto;
  }
  .thead-item, .penjualan-item tr {
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

<div class="row">
  <div class="col-md-6">
    <div class="box box-danger">
      <div class="box-header with-border">
        <div class="pull-left">
         <?php echo date('l, d M Y') ?>
       </div>
       <div class="pull-right">
         Kasir : <?php echo $this->session->userdata('nama_petugas'); ?>
       </div>
     </div>
     <div class="box-body">
      <form action="<?php echo base_url('penjualan/proses') ?>" method="POST" class="form-penjualan" enctype="multipart/form-data">
        <input type="hidden" name="id_petugas" value="<?php echo $this->session->userdata('id_petugas'); ?>">
        <input type="hidden" name="faktur_penjualan" value="<?php echo $faktur_penjualan ?>">
        <input type="hidden" class="member" name="member" value="0">
        <input type="hidden" name="id_service" value="">
        <div class="pelanggan_baru"></div>
        <div class="form-group">
          <div class="input-group input-group">
            <select required="" name="id_pelanggan" id="id_pelanggan" class="form-control select2 pelanggan pelanggan-wrapper">
              <?php foreach ($pelanggan as $row): ?>
                <option value="<?php echo $row['id_pelanggan'] ?>">
                  <?php echo $row['nama_pelanggan'] ?>
                </option>
              <?php endforeach ?>
            </select>
            <span class="input-group-btn">
              <button type="button" class="btn btn-info btn-flat"><i class="fa fa-users"></i></button>
            </span>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group input-group">
            <select required="" name="id_agen" id="id_agen" class="form-control select2 agen agen-wrapper">
              <?php foreach ($agen as $row): ?>
                <option value="<?php echo $row['id_agen'] ?>">
                  <?php echo $row['nama_agen'] ?>
                </option>
              <?php endforeach ?>
            </select>
            <span class="input-group-btn">
              <button type="button" class="btn btn-info btn-flat"><i class="fa fa-users"></i></button>
            </span>
          </div>
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
        <div class="form-group">
          <div class="table-responsive">
            <table class="table">
              <thead class="thead-item">
                <tr>
                  <th width="30%">Nama</th>
                  <th>Golongan</th>
                  <th>Harga</th>
                  <th>Diskon</th>
                  <th>Qty</th>
                  <th>Subtotal</th>
                  <th><i class="fa fa-gear"></i></th>
                </tr>
              </thead>
              <tbody class="penjualan-item">

              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <table class="table">
         <tr>
          <th>Total Item</th>
          <td colspan="2"><input readonly="" type="text" class="form-control total_item" name="total_item" value="0"></td>
        </tr>
        <tr>
          <th>Diskon (%) | Potongan</th>
          <td><input type="number" class="form-control diskon" name="diskon" autocomplete="off" value="0"></td>
          <td><input autocomplete="off" type="text" class="form-control potongan" name="potongan" autocomplete="off" value="0"></td>
          <input type="hidden" name="potongan_rp" class="potongan_rp">
        </tr>
        <tr>
          <th>Jumlah Bayar</th>
          <td colspan="2"><input readonly="" type="text" class="form-control jumlah_bayar" name="jumlah_bayar" value="Rp. 0"></td>
        </tr>
          <th>Keterangan</th>
          <td colspan="2"><input  type="text" class="form-control keterangan" name="keterangan" placeholder="Keterangan"></td>
        </tr>
        <input type="hidden" name="metode_pembayaran" value="Cash">
        <input type="hidden" name="tgl_jatuh_tempo">
        <tr class="ship_nama">
          <th>Nama</th>
          <td colspan="2"><input type="text" placeholder="Nama" name="nama_pengiriman" id="nama_pengiriman" class="form-control"></td>
        </tr>
        <tr class="ship_alamat">
          <th>Alamat</th>
          <td colspan="2"><input type="text" placeholder="Alamat" name="alamat_pengiriman" id="alamat_pengiriman" class="form-control"></td>
        </tr>
        <input type="hidden" name="cash" value="0">
        <input type="hidden" name="no_kredit" value="">
        <tr class="no_debit">
          <th>No Debit</th>
          <td colspan="2">
            <input type="text" name="no_debit" id="no_debit" class="form-control" placeholder="No ebit">
          </td>
        </tr>
        <tr class="lampiran">
          <th>Lampiran</th>
          <td colspan="2">
            <input type="file" name="lampiran" id="lampiran" class="form-control">
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <button type="submit" class="btn btn-primary btn-block btn-flat konfirmasi-penjualan">Konfirmasi</button>
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <button type="submit" class="btn btn-danger btn-block btn-flat batal">Batal</button>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div class="col-md-6">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-danger">
        <div class="box-header with-border">
          <div class="pull-left">
            <?php echo $faktur_penjualan ?>
          </div>
          <div class="pull-right">
            <input type="text" class="total_jumlah_bayar" style="text-align: right;border:none; font-size: 50px" value="Rp. 0">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-danger">
        <div class="box-header with-border">
          <div class="box-body">
           <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table" id="table-cari-barang" width="100%">
                  <thead>
                    <tr>
                      <th>Kode Barang</th>
                      <th>Nama Barang</th>
                      <th>GLG 1</th>
                      <th>GLG 2</th>
                      <th>GLG 3</th>
                      <th>GLG 4</th>
                      <th>Stok</th>
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

  $pengaturan = $this->db->get('pengaturan')->row_array();

  echo "const pengaturan = " . json_encode($pengaturan). "; ";

  echo "const judul = '" . $judul . "';";

  ?>
</script>
