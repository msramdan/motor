
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
              <p style="color: red">Note* : Untuk ceklis read,create, update, delete dan export silahkan ceklis terlebih dahulu access list nya</p>
              <?php
                foreach ($row->result() as $value) {
                  $menuId = $value->menu_id;
                  $querySubMenu = "SELECT `sub_menu`.`nama_sub_menu`,`sub_menu`.`sub_menu_id` as id_sub,`menu`.*
                  FROM `sub_menu` JOIN `menu` 
                    ON `sub_menu`.`menu_id` = `menu`.`menu_id`
                  WHERE `sub_menu`.`menu_id` = $menuId";
                  $subMenu = $this->db->query($querySubMenu)->result_array();
                  $o = ucfirst($value->menu);
                  $bor = ucwords(strtolower($o));
                  $menutrimmed = preg_replace('/\s+/', '', $bor);
              ?>
              <div class="accordion" id="accordion<?php echo $menuId.$menutrimmed ?>" role="tablist" aria-multiselectable="true">
                <div class="panel">
                  <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion<?php echo $menuId.$menutrimmed ?>" href="#collapse<?php echo $menuId.$menutrimmed ?>" aria-expanded="false" aria-controls="collapse<?php echo $menuId.$menutrimmed ?>">
                    <h4 class="panel-title">Menu <?= $value->menu ?></h4>
                  </a>
                  <div id="collapse<?php echo $menuId.$menutrimmed ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                      <?php
                        foreach ($subMenu as $sm) :
                          $coba = check_access($role['level_id'],$sm['id_sub']);
                          $s = ucfirst($sm['nama_sub_menu']);
                          $bar = ucwords(strtolower($s));
                          $submenunametrimmed = preg_replace('/\s+/', '', $bar);
                          ?>
                          <div class="accordion" id="accordion<?php echo $sm['id_sub'].$submenunametrimmed ?>" role="tablist" aria-multiselectable="true">
                            <div class="panel">
                              <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion<?php echo $sm['id_sub'].$submenunametrimmed ?>" href="#collapse<?php echo $sm['id_sub'].$submenunametrimmed ?>" aria-expanded="false" aria-controls="collapse<?php echo $sm['id_sub'].$submenunametrimmed ?>">
                                <h4 class="panel-title">

                                  <input class="form-check-input" type="checkbox" <?= check_access($role['level_id'],$sm['id_sub']); ?> data-role="<?= $role['level_id']; ?>"data-menu="<?= $sm['id_sub'] ?>">
                                    <label style="font-weight: inherit; font-size: medium;" class="" for="customCheck1"><?= $sm['nama_sub_menu'] ?></label>

                                </h4>
                              </a>
                              <div id="collapse<?php echo $sm['id_sub'].$submenunametrimmed ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                  <table class="table table-bordered table-striped" id="">
                                    <thead>
                                      <tr>
                                        <th>Status</th>
                                        <th>Operation</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                       $coba = check_access($role['level_id'],$sm['id_sub']); ?>
                                      

                                      <tr>
                                        <td>
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
                                        </td>
                                        <td>
                                          <label class="" for="customCheck1">Create</label><br>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>
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
                                        </td>
                                        <td>
                                          <label class="" for="customCheck1">Read</label><br>    
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>
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
                                        </td>
                                        <td>
                                          <label class="" for="customCheck1">Update</label><br>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>
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
                                        </td>
                                        <td>
                                          <label class="" for="customCheck1">Delete</label><br>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>
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
                                        </td>
                                        <td>
                                          <label class="" for="customCheck1">Export</label><br>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                     

                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>