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

<form action="<?php echo base_url('pembelian/proses') ?>" method="POST" class="form-pembelian" enctype="multipart/form-data">
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
        <input type="hidden" name="faktur_pembelian" value="<?php echo faktur_no() ?>">
        <div class="form-group">
          <select name="id_supplier" id="id_supplier" class="form-control select2 supplier">
            <?php foreach ($supplier as $row): ?>
              <option value="<?php echo $row['id_supplier'] ?>"><?php echo $row['nama_supplier'] ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <div class="form-group <?php if(form_error('barcode')) echo 'has-error'?>">
                <input type="text" id="barcode" name="barcode" class="form-control barcode" placeholder="Barcode" autocomplete="off" autofocus="">
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

            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer">
        <table class="table">
         <tr>
          <th>Total Item</th>
          <td colspan="2"><input readonly="" type="text" class="form-control total_item" name="total_item" value="0"></td>
        </tr>
        <tr>
          <th>Tgl Pembelian</th>
          <td><input required="" type="datetime-local" class="form-control tgl_pembelian" name="tgl_pembelian" value="<?php echo date("Y-m-d\TH:i:s", strtotime( date('Y-m-d H:i:s') ))  ?>"></td>
        </tr>
        <tr>
          <th>Referensi</th>
          <td><input type="text" class="form-control" name="referensi" placeholder="Referensi"></td>
        </tr>
        <tr class="no_kredit">
          <th>No Kredit</th>
          <td colspan="2">
            <input type="text" name="no_kredit" id="no_kredit" class="form-control" placeholder="No Kredit">
          </td>
        </tr>
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
          <th>Total Bayar</th>
          <td><input readonly="" type="text" class="form-control jumlah_bayar" name="jumlah_bayar" value="Rp. 0"></td>
        </tr>
        <tr>
          <th>Cash</th>
          <td><input type="text" autocomplete="off" class="form-control cash" name="cash"></td>
        </tr>
        <tr>
          <th>Kembalian</th>
          <td><input readonly="" type="text" class="form-control kembalian"></td>
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

  echo "const judul = " . "'$judul'";

  ?>
</script>