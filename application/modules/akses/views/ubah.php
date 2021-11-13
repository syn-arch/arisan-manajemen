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
            <a href="<?php echo base_url('petugas/akses') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
          </div>
        </div>
      </div>
      <div class="box-body">

        <div class="row">
          <div class="col-md-6">
            <table class="table">
              <tr>
                <th>Nama Role</th>
                <td><?php echo $role['nama_role'] ?></td>
              </tr>
            </table>
          </div>
        </div>

        <div class="row">
          <div class="col-md-8">
            <table class="table">
              <tr>
                <th>Nama Menu</th>
                <th>Akses</th>
              </tr>
              <?php 
                      $this->db->order_by('urutan', 'asc');
              $menu = $this->db->get_where('menu', ['submenu' => 0])->result_array(); 
              ?>
              <?php foreach ($menu as $row): ?>
                <tr>
                  <td>
                    <p><?php echo $row['nama_menu'] ?></p>
                    <?php if ($this->db->get_where('menu', ['submenu' => $row['id_menu']])->row_array()): ?>
                      <table class="table mt-5">
                        <tr>
                          <th>Submenu <?php echo $row['nama_menu'] ?></th>
                          <th>Akses</th>
                        </tr>
                        <?php 
                                    $this->db->order_by('urutan', 'asc');
                        $submenu = $this->db->get_where('menu',['submenu' => $row['id_menu']])->result_array(); 
                        ?>
                        <?php foreach ($submenu as $row_submenu): ?>
                          <tr>
                            <td><?php echo $row_submenu['nama_menu'] ?></td>
                            <td><input type="checkbox" class="ubah_menu" <?php echo check_menu($row_submenu['id_menu'], $role['id_role']) ?> data-menu="<?php echo $row_submenu['id_menu'] ?>" data-role="<?php echo $role['id_role'] ?>"></td>
                          </tr>
                        <?php endforeach ?>
                      </table>
                    <?php endif ?>
                  </td>
                  <td><input type="checkbox" class="ubah_menu" <?php echo check_menu($row['id_menu'], $role['id_role']) ?> data-menu="<?php echo $row['id_menu'] ?>" data-role="<?php echo $role['id_role'] ?>"></td>
                </tr>
              <?php endforeach ?>
            </table>  
          </div>
        </div>
      </div>
    </div>
  </div>
</div>