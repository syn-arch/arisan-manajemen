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
         <?php echo date('l, d M Y', strtotime($penjualan['tgl'])) ?>
       </div>
       <div class="pull-right">
         Kasir : <?php echo $this->session->userdata('nama_petugas'); ?>
       </div>
     </div>
     <div class="box-body">

      <form action="<?php echo base_url('penjualan/proses_update') ?>" method="POST" class="form-penjualan" enctype="multipart/form-data">
        <input type="hidden" name="hold" value="<?php echo $this->input->get('hold') ? $this->input->get('hold') : false ?>">
        <input type="hidden" name="id_outlet" value="<?php echo $penjualan['id_outlet']; ?>">
        <input type="hidden" name="id_petugas" value="<?php echo $this->session->userdata('id_petugas'); ?>">
        <input type="hidden" name="faktur_penjualan" value="<?php echo $penjualan['faktur_penjualan'] ?>">
        <input type="hidden" name="id_service" value="">
        <?php if ($penjualan['jenis'] == 'member'): ?>
          <input type="hidden" class="member" name="member" value="1">
        <?php else: ?>
          <input type="hidden" class="member" name="member" value="0">
        <?php endif ?>
        <div class="pelanggan_baru"></div>
        <div class="form-group">
          <div class="input-group input-group">
            <select required="" name="id_pelanggan" id="id_pelanggan" class="form-control pelanggan select2">
              <?php foreach ($pelanggan as $row): ?>
                <option 
                <?php echo $penjualan['id_pelanggan'] == $row['id_pelanggan'] ? 'selected' : ''; ?> 
                value="<?php echo $row['id_pelanggan'] ?>">
                <?php echo $row['nama_pelanggan'] ?>
              <?php endforeach ?>
            </select>
            <span class="input-group-btn">
              <button type="button"  class="btn btn-info btn-flat"><i class="fa fa-users"></i></button>
            </span>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group input-group">
            <select required="" name="id_agen" id="id_agen" class="form-control agen select2">
              <?php foreach ($agen as $row): ?>
                <option 
                <?php echo $penjualan['id_agen'] == $row['id_agen'] ? 'selected' : ''; ?> 
                value="<?php echo $row['id_agen'] ?>">
                <?php echo $row['nama_agen'] ?>
              <?php endforeach ?>
            </select>
            <span class="input-group-btn">
              <button type="button"  class="btn btn-info btn-flat"><i class="fa fa-users"></i></button>
            </span>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group input-group">
            <select required="" name="id_kelompok" id="id_kelompok" class="form-control kelompok select2">
              <?php foreach ($kelompok as $row): ?>
                <option 
                <?php echo $penjualan['id_kelompok'] == $row['id_kelompok'] ? 'selected' : ''; ?> 
                value="<?php echo $row['id_kelompok'] ?>">
                <?php echo $row['nama_kelompok'] ?>
              <?php endforeach ?>
            </select>
            <span class="input-group-btn">
              <button type="button"  class="btn btn-info btn-flat"><i class="fa fa-users"></i></button>
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

                <?php foreach ($detail_penjualan as $row): ?>
                  <?php 

                  $this->db->select($row['type_golongan'] . ' AS harga_jual');
                  $harga_jual = $this->db->get_where('barang', ['id_barang' => $row['id_barang']])->row()->harga_jual;

                  $rpdiskon = ($row['diskon'] / 100) * $harga_jual;
                  $tot = $harga_jual - $rpdiskon;
                  $harga_brg = $tot;
                  $harga_asli = $harga_jual;
                  ?>
                  <tr data-id="<?php echo $row['id_barang'] ?>">
                    <input type="hidden" name="id_barang[]" value="<?php echo $row['id_barang'] ?>">
                    <input type="hidden" name="type_golongan[]" value="<?php echo $row['type_golongan'] ?>">
                    <input data-subtot="<?php echo $row['id_barang'] ?>" type="hidden" name="total_harga[]" value="<?php echo $row['total_harga'] ?>">
                    <td width="30%"><?php echo $row['nama_pendek'] ?></td>
                    <td>
                      <select class="form-control gl" name="type_golongan[]">
                        <option value="golongan_1" <?php echo $row['type_golongan'] == 'golongan_1' ? 'selected' : '' ?>>G 1</option>
                        <option value="golongan_2" <?php echo $row['type_golongan'] == 'golongan_2' ? 'selected' : '' ?>>G 2</option>
                        <option value="golongan_3" <?php echo $row['type_golongan'] == 'golongan_3' ? 'selected' : '' ?>>G 3</option>
                        <option value="golongan_4" <?php echo $row['type_golongan'] == 'golongan_4' ? 'selected' : '' ?>>G 4</option>
                      </select>
                    </td>
                    <td data-secret="<?php echo $row['id_barang'] ?>" class="harga_brg"><?php echo number_format($harga_jual) ?></td>
                    <td><?php echo $row['diskon'] ?></td>
                    <td><input class="form-control qty" step="0.1" name="jumlah[]" data-id="<?php echo $row['id_barang'] ?>" data-harga="<?php echo $harga_brg ?>" type="number" value="<?php echo $row['jumlah'] ?>" style="width: 5em"></td>
                    <td class="subtotal" data-kode="<?php echo $row['id_barang'] ?>"><?php echo number_format($row['total_harga'], '0','','.') ?></td>
                    <td><a class="btn btn-danger btn-flat hapus-barang" data-id="<?php echo $row['id_barang'] ?>" data-harga="<?php echo $harga_brg ?>"><i class="fa fa-trash"></i></a></td>
                  </tr>
                <?php endforeach ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <table class="table">
         <tr>
          <th>Total Item</th>
          <td colspan="2"><input readonly="" type="text" class="form-control total_item" name="total_item" value="<?php echo $penjualan['total_item'] ?>"></td>
        </tr>
        <tr>
          <th>Diskon (%) | Potongan</th>
          <td><input type="number" class="form-control diskon" name="diskon" autocomplete="off" value="<?php echo $penjualan['diskon'] ?>"></td>
          <td><input type="number" class="form-control potongan" name="potongan" autocomplete="off" value="<?php echo $penjualan['potongan'] ?>"></td>
        </tr>
        <tr>
          <th>Jumlah Bayar</th>
          <td colspan="2"><input readonly="" type="text" class="form-control jumlah_bayar" name="jumlah_bayar" value="<?php echo "Rp. " . number_format($penjualan['total_bayar']) ?>"></td>
        </tr>
      </tr>
      <tr>
        <th>Keterangan</th>
        <td colspan="2"><input  type="text" class="form-control keterangan" name="keterangan" placeholder="Keterangan" value="<?php echo $penjualan['keterangan'] ?>"></td>
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
            <?php echo $penjualan['faktur_penjualan']; ?>
          </div>
          <div class="pull-right">
            <input type="text" class="total_jumlah_bayar" style="text-align: right;border:none; font-size: 50px" value="<?php echo "Rp. " . number_format($penjualan['total_bayar']) ?>">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-danger">
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

</form>

<script>
  <?php 

  $pengaturan = $this->db->get('pengaturan')->row_array();

  echo "const pengaturan = " . json_encode($pengaturan) . "; ";

  echo "const judul = '" . $judul. "'; ";

  echo "const total_bayar_rp = " . $penjualan['total_bayar']. "; ";


  ?>
</script>   
