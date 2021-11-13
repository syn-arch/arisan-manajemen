<div class="row">
    <div class="col-md-6 col-xs-12">
        <div class="box box-danger">
            <div class="box-header with-border">
              <h4 class="box-title">Silahkan Masukan Saldo Awal</h4>
            </div>
            <div class="box-body">
              <form method="POST">
                  <div class="form-group <?php if(form_error('uang_awal')) echo 'has-error'?>">
                      <label for="uang_awal">Saldo Awal</label>
                      <input type="text" id="uang_awal" name="uang_awal" class="form-control uang_awal " placeholder="Saldo Awal" value="<?php echo set_value('uang_awal') ?>">
                      <?php echo form_error('uang_awal', '<small style="color:red">','</small>') ?>
                  </div>
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">Submit</button>
                  </div>
              </form>
            </div>
        </div>
    </div>
</div>