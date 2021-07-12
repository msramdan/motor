
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
                <p style="color: red">Note* : Untuk ceklis read,create, update, delete dan export silahkan ceklis terlebih dahulu access list nya</p>
                <th>No</th>
                <th>Nama</th>
                <th>List</th>
                <th>Read</th>
                <th>Create</th>
                <th>Update</th>
                <th>Delete</th>
                <th>Export Excel</th>
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

                  <!-- Query Untuk Akses Read -->

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

                 <?php foreach ($subMenu as $sm) :
                 $coba =check_access($role['level_id'],$sm['id_sub']); ?>

                 <?php if ($coba=='') { ?>
                   <input class="form-check-input-read" type="checkbox" disabled=""
                        data-role="<?= $role['level_id']; ?>"
                        data-menu="<?= $sm['id_sub'] ?>"
                      >

                 <?php }else{ ?>
                  <input class="form-check-input-read" type="checkbox" <?= check_access_read($role['level_id'],$sm['id_sub']); ?>
                        data-role="<?= $role['level_id']; ?>"
                        data-menu="<?= $sm['id_sub'] ?>"
                      >
                 <?php } ?>
                  <label class="" for="customCheck1">Ya</label><br>

                <?php endforeach; ?>
                  </div>


                  </td>

                  <!-- Query Untuk Akses Create -->

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

                 <?php foreach ($subMenu as $sm) :
                 $coba =check_access($role['level_id'],$sm['id_sub']); ?>

                 <?php if ($coba=='') { ?>
                   <input class="form-check-input-create" type="checkbox" disabled=""
                        data-role="<?= $role['level_id']; ?>"
                        data-menu="<?= $sm['id_sub'] ?>"
                      >

                 <?php }else{ ?>
                  <input class="form-check-input-create" type="checkbox" <?= check_access_create($role['level_id'],$sm['id_sub']); ?>
                        data-role="<?= $role['level_id']; ?>"
                        data-menu="<?= $sm['id_sub'] ?>"
                      >
                 <?php } ?>
                  <label class="" for="customCheck1">Ya</label><br>

                <?php endforeach; ?>
                  </div>


                  </td>

                  <!-- Query Untuk Akses Update -->

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

                 <?php foreach ($subMenu as $sm) :
                 $coba =check_access($role['level_id'],$sm['id_sub']); ?>

                 <?php if ($coba=='') { ?>
                   <input class="form-check-input-update" type="checkbox" disabled=""
                        data-role="<?= $role['level_id']; ?>"
                        data-menu="<?= $sm['id_sub'] ?>"
                      >

                 <?php }else{ ?>
                  <input class="form-check-input-update" type="checkbox" <?= check_access_update($role['level_id'],$sm['id_sub']); ?>
                        data-role="<?= $role['level_id']; ?>"
                        data-menu="<?= $sm['id_sub'] ?>"
                      >
                 <?php } ?>
                  <label class="" for="customCheck1">Ya</label><br>

                <?php endforeach; ?>
                  </div>


                  </td>

                  <!-- Query Untuk Akses Delete -->

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

                 <?php foreach ($subMenu as $sm) :
                 $coba =check_access($role['level_id'],$sm['id_sub']); ?>

                 <?php if ($coba=='') { ?>
                   <input class="form-check-input-delete" type="checkbox" disabled=""
                        data-role="<?= $role['level_id']; ?>"
                        data-menu="<?= $sm['id_sub'] ?>"
                      >

                 <?php }else{ ?>
                  <input class="form-check-input-delete" type="checkbox" <?= check_access_delete($role['level_id'],$sm['id_sub']); ?>
                        data-role="<?= $role['level_id']; ?>"
                        data-menu="<?= $sm['id_sub'] ?>"
                      >
                 <?php } ?>
                  <label class="" for="customCheck1">Ya</label><br>

                <?php endforeach; ?>
                  </div>


                  </td>

                  <!-- Query Untuk Akses Export -->

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

                 <?php foreach ($subMenu as $sm) :
                 $coba =check_access($role['level_id'],$sm['id_sub']); ?>

                 <?php if ($coba=='') { ?>
                   <input class="form-check-input-export" type="checkbox" disabled=""
                        data-role="<?= $role['level_id']; ?>"
                        data-menu="<?= $sm['id_sub'] ?>"
                      >

                 <?php }else{ ?>
                  <input class="form-check-input-export" type="checkbox" <?= check_access_export($role['level_id'],$sm['id_sub']); ?>
                        data-role="<?= $role['level_id']; ?>"
                        data-menu="<?= $sm['id_sub'] ?>"
                      >
                 <?php } ?>
                  <label class="" for="customCheck1">Ya</label><br>

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


      $('.form-check-input-read').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');
        $.ajax({
          url: "<?= base_url('level/changeaccess_read'); ?>",
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

      $('.form-check-input-create').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');
        $.ajax({
          url: "<?= base_url('level/changeaccess_create'); ?>",
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

      $('.form-check-input-update').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');
        $.ajax({
          url: "<?= base_url('level/changeaccess_update'); ?>",
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

      $('.form-check-input-delete').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');
        $.ajax({
          url: "<?= base_url('level/changeaccess_delete'); ?>",
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

      $('.form-check-input-export').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');
        $.ajax({
          url: "<?= base_url('level/changeaccess_export'); ?>",
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