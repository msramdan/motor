
            <div class="page-nama_sub_menu">
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
            <div class='row'>
              <div class="alert alert-warning alert-dismissible">
                Note : Ketika Menghapus Menu Parent maka sub menu yang di bawahnya akan terhapus Juga
                </div>  
              <div class='col-md-9'>
            
            </div>
              <div class="col-md-6">
               <div style="padding-bottom: 10px;">
        <?php echo anchor(site_url('menu/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Menu Parent', 'class="btn btn-danger btn-sm"'); ?>
          
        </div>
                <div class="box-body" style="overflow-x: scroll; ">
                <table class="table table-bordered table-striped" id="table1">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Icon</th>
                        <th>Urutan</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1;
                      foreach ($row->result() as $key => $value) { ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $value->menu ?></td>
                          <td><?= $value->icon ?></td>
                          <td><?= $value->urutan ?></td>
                          <td style="text-align:center" width="200px">
                <?php 
                echo anchor(site_url('menu/update/'.$value->menu_id),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-primary btn-sm"'); 
                echo '  '; 
                echo anchor(site_url('menu/delete/'.$value->menu_id),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
                ?>
              </td>
                        </tr>
                      <?php
                      } ?>

                    </tbody>

                  </table>
                <div class="row">

                </div>
              </div>
            </div>

            <div class="col-md-6">
            <div style="padding-bottom: 10px;">
        <?php echo anchor(site_url('sub_menu/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Sub Menu', 'class="btn btn-danger btn-sm"'); ?>
          
        </div>      
                <div class="box-body" style="overflow-x: scroll; ">
                <table class="table table-bordered table-striped" id="table2">
            <thead>
              <tr>
                <th>No</th>
                <th>Parent</th>
                <th>Sub Menu</th>
                <th>Url</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($row2->result() as $key => $value) { ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $value->menu ?></td>
                  <td><?= $value->nama_sub_menu ?></td>
                  <td><?= $value->url ?></td>
                  <td style="text-align:center" width="200px">
        <?php 
        echo anchor(site_url('sub_menu/update/'.$value->sub_menu_id),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-primary btn-sm"'); 
        echo '  '; 
        echo anchor(site_url('sub_menu/delete/'.$value->sub_menu_id),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
        ?>
      </td>

                </tr>
              <?php
              } ?>

            </tbody>

          </table>
                <div class="row">

                </div>
              </div>
            </div>

            </div>
            </div>
</div>