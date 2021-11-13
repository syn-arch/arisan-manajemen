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
                        <a href="<?php echo base_url('penjualan/pembayaran/' . $faktur_penjualan) ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                      <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="no_debit" value="">
                        <input type="hidden" name="faktur_penjualan" value="<?php echo $faktur_penjualan ?>">
                        <input type="hidden" name="hold" value="<?php echo $this->input->get('hold') ?>">
                          <div class="form-group <?php if(form_error('dibayar_dengan')) echo 'has-error'?>">
                              <label for="dibayar_dengan">Metode Pembayaran</label>
                              <select name="metode_pembayaran" id="metode_pembayaran" class="form-control metode_pembayaran">
                                  <option value="Cash" selected>Cash</option>
                                  <option value="Debit">Debit</option>
                                  <option value="Kredit">Kredit</option>
                              </select>
                              <?php echo form_error('dibayar_dengan', '<small style="color:red">','</small>') ?>
                          </div>
                          <div class="form-group <?php if(form_error('nominal')) echo 'has-error'?>">
                              <label for="nominal">Nominal</label>
                              <input type="text" id="nominal" name="nominal" class="form-control nominal " placeholder="Nominal" value="<?php echo $nominal ?>">
                              <?php echo form_error('nominal', '<small style="color:red">','</small>') ?>
                          </div>
                          <div class="form-group no_kredit <?php if(form_error('no_kredit')) echo 'has-error'?>">
                              <label for="no_kredit">No Kredit</label>
                              <input type="text" id="no_kredit" name="no_kredit" class="form-control no_kredit " placeholder="No Kredit" value="<?php echo set_value('no_kredit') ?>">
                              <?php echo form_error('no_kredit', '<small style="color:red">','</small>') ?>
                          </div>
                          <div class="form-group lampiran <?php if(form_error('lampiran')) echo 'has-error'?>">
                              <label for="lampiran">Lampiran</label>
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
