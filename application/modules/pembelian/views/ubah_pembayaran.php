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
                        <a href="<?php echo base_url('pembelian/pembayaran/' . $faktur_pembelian) ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                      <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_pembayaran" value="<?php echo $pembayaran['id_pembayaran'] ?>">
                        <input type="hidden" name="faktur_pembelian" value="<?php echo $faktur_pembelian ?>">
                          <div class="form-group <?php if(form_error('dibayar_dengan')) echo 'has-error'?>">
                              <label for="dibayar_dengan">Metode Pembayaran</label>
                              <select name="metode_pembayaran" id="metode_pembayaran" class="form-control metode_pembayaran">
                                  <option value="Cash" <?php echo $pembayaran['dibayar_dengan'] == 'Cash' ? 'Selected' : '' ?>>Cash</option>
                                  <option value="Debit" <?php echo $pembayaran['dibayar_dengan'] == 'Debit' ? 'Selected' : '' ?>>Debit</option>
                                  <option value="Kredit" <?php echo $pembayaran['dibayar_dengan'] == 'Kredit' ? 'Selected' : '' ?>>Kredit</option>
                              </select>
                              <?php echo form_error('dibayar_dengan', '<small style="color:red">','</small>') ?>
                          </div>
                          <div class="form-group <?php if(form_error('nominal')) echo 'has-error'?>">
                              <label for="nominal">Nominal</label>
                              <input type="text" id="nominal" name="nominal" class="form-control nominal " placeholder="Nominal" value="<?php echo $pembayaran['nominal'] ?>">
                              <?php echo form_error('nominal', '<small style="color:red">','</small>') ?>
                          </div>
                          <div class="form-group no_kredit <?php if(form_error('no_kredit')) echo 'has-error'?>">
                              <label for="no_kredit">No Kredit</label>
                              <input type="text" id="no_kredit" name="no_kredit" class="form-control no_kredit " placeholder="No Kredit" value="<?php echo $pembayaran['no_kredit'] ?>">
                              <?php echo form_error('no_kredit', '<small style="color:red">','</small>') ?>
                          </div>
                          <div class="form-group no_debit <?php if(form_error('no_debit')) echo 'has-error'?>">
                              <label for="no_debit">No Debit</label>
                              <input type="text" id="no_debit" name="no_debit" class="form-control no_debit " placeholder="No Debit" value="<?php echo $pembayaran['no_debit'] ?>">
                              <?php echo form_error('no_debit', '<small style="color:red">','</small>') ?>
                          </div>
                          <div class="form-group lampiran <?php if(form_error('lampiran')) echo 'has-error'?>">
                              <label for="lampiran">Lampiran</label>
                              <?php if ($pembayaran['lampiran'] != ''): ?>
                                <img src="<?php echo base_url('assets/img/pembelian/' . $pembayaran['lampiran']) ?>" alt="" class="img-responsive">
                              <?php endif ?>
                              <input type="file" id="lampiran" name="lampiran" class="form-control lampiran " placeholder="Lampiran" value="<?php echo set_value('lampiran') ?>">
                              <?php echo form_error('lampiran', '<small style="color:red">','</small>') ?>
                          </div>
                          <div class="form-group">
                              <button type="submit" class="btn btn-primary btn-block">Submit</button>
                          </div>
                      </form>  
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
