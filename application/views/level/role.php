
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
                  <a class="panel-heading collapsed" role="tab" id="heading<?php echo $menuId.$menutrimmed ?>" data-toggle="collapse" data-parent="#accordion<?php echo $menuId.$menutrimmed ?>" href="#collapse<?php echo $menuId.$menutrimmed ?>" aria-expanded="false" aria-controls="collapse<?php echo $menuId.$menutrimmed ?>">
                    <h4 class="panel-title">Menu <?= $value->menu ?></h4>
                  </a>
                  <div id="collapse<?php echo $menuId.$menutrimmed ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $menuId.$menutrimmed ?>">
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
                              <a class="panel-heading collapsed" role="tab" id="heading<?php echo $sm['id_sub'].$submenunametrimmed ?>" data-toggle="collapse" data-parent="#accordion<?php echo $sm['id_sub'].$submenunametrimmed ?>" href="#collapse<?php echo $sm['id_sub'].$submenunametrimmed ?>" aria-expanded="false" aria-controls="collapse<?php echo $sm['id_sub'].$submenunametrimmed ?>">
                                <h4 class="panel-title">

                                  <input class="form-check-input" type="checkbox" <?= check_access($role['level_id'],$sm['id_sub']); ?> data-role="<?= $role['level_id']; ?>"data-menu="<?= $sm['id_sub'] ?>" onclick="changeAccessfor(this, 'submenu','<?php echo $submenunametrimmed ?>','<?php echo $role['nama_level'] ?>')">
                                    <label style="font-weight: inherit; font-size: medium;" class="" for="customCheck1"><?= $sm['nama_sub_menu'] ?><?php echo check_access($role['level_id'],$sm['id_sub']) == "checked='checked'" ? "<span id='iconstatussubmenufor".$sm['id_sub'].$submenunametrimmed."' style='margin: 0 7px;'><i class='fa fa-unlock' aria-hidden='true' style='color: #26B99A;'></i></span>" : "<span style='margin: 0 7px;'><i class='fa fa-lock' aria-hidden='true' style='color: red;'></i></span>"; ?></label>

                                </h4>
                              </a>
                              <div id="collapse<?php echo $sm['id_sub'].$submenunametrimmed ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $sm['id_sub'].$submenunametrimmed ?>">
                                <div class="panel-body">
                                  

                                  <?php
                                  $parametera = [
                                      'level_id'    =>  $role['level_id'],
                                      'sub_menu_id' =>  $sm['id_sub'],
                                      'namasubmenu' =>  $submenunametrimmed,
                                      'namalevel' => $role['nama_level'],
                                      'namamenu' => $value->menu,
                                  ];
                                  $this->view('level/access_list_submenu',$parametera) ?>
                                  

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