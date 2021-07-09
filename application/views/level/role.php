
            <div class="page-nama_sub_menu">
                          <div class="nama_sub_menu_left">
                          <h3>User Level : <?= $role['nama_level'] ?></h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
            <div class='row'>
            <div class='col-md-9'>
            </div>
        
   
        <div class="row" style="margin-bottom: 10px">
            
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                
            </div>
        </div>
        <div class="box-body" style="overflow-x: scroll; ">
             <table class="table table-bordered table-striped" id="">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Access</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($row->result() as $key => $value) { ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $value->menu ?></td>

                  <td>
                    <div class="form-check">
                                      <?php
                $menuId = $value->menu_id;
                $querySubMenu = "SELECT `sub_menu`.`nama_sub_menu`,`sub_menu`.`sub_menu_id` as id_sub,`menu`.*
                FROM `sub_menu` JOIN `menu` 
                  ON `sub_menu`.`menu_id` = `menu`.`menu_id`
               WHERE `sub_menu`.`menu_id` = $menuId
               ";
                $subMenu = $this->db->query($querySubMenu)->result_array();
                ?>

                 <?php foreach ($subMenu as $sm) : ?>
                  <input class="form-check-input" type="checkbox" <?= check_access($role['level_id'],$sm['id_sub']); ?>
                        data-role="<?= $role['level_id']; ?>"
                        data-menu="<?= $sm['id_sub'] ?>"
                      >
                      <label class="" for="customCheck1"><?= $sm['nama_sub_menu'] ?></label><br>

                <?php endforeach; ?>                    
                    </div>

                  </td>
                    </form>
                </tr>
              <?php
              } ?>

            </tbody>
          </table>
        </div>
                    </div>
            </div>
            </div>
            </div>
</div>

    <script type="text/javascript">
      $('.form-check-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');
        $.ajax({
          url: "<?= base_url('level/changeaccess'); ?>",
          type: "post",
          data: {
            menuId: menuId,
            roleId: roleId,
          },
          success: function() {
            document.location.href = "<?= base_url('level/role/') ?>" + roleId;
          }

        });

      })
    </script>