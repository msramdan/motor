
            <div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA USER</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
            <div class='row'>
            <div class='col-md-9'>
            <div style="padding-bottom: 10px;">
        <?php echo show_button($menu_accessed, 'create');
        //echo show_button($menu_accessed, 'export');?>
        </div>
            </div>
            <div class='col-md-3'>
            <form action="<?php echo site_url('user/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('user'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
            </div>
        
   
        <div class="row" style="margin-bottom: 10px">
            
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                
            </div>
        </div>
        <div class="box-body" style="overflow-x: scroll; ">
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
        <th>Nama Lengkap</th>
        <th>Username</th>
        <th>Level</th>
        <th>Email</th>
        <th>No Hp User</th>
        <th>Alamat User</th>
        <th>Photo</th>
        <th>Access Unit</th>
        <th>Action</th>
            </tr><?php
            foreach ($user_data as $user)
            {
                ?>
                <tr>
            <td width="10px"><?php echo ++$start ?></td>
            <td><?php echo $user->nama_user ?></td>
            <td><?php echo $user->username ?></td>
            <td><?php echo $user->nama_level ?></td>
            <td><?php echo $user->email ?></td>
            <td><?php echo $user->no_hp_user ?></td>
            <td><?php echo $user->alamat_user ?></td>
            <td><img style="width: 40%; text-align: center;" src="<?= base_url() ?>assets/img/user/<?= $user->photo ?>"></td>
            <td><a href="<?=site_url('user/akses_unit/'.$user->user_id)?>" class ="btn btn-success btn-xs"><i class="fa fa-unlock" aria-hidden="true"></i> Access</a></td>      
            <td style="text-align:center" width="200px">
                <?php echo show_button($menu_accessed, 'update',$user->user_id); ?>
                <?php echo show_button($menu_accessed, 'delete',$user->user_id); ?>
        </tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
        </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
        </div>
                    </div>
            </div>
            </div>
            </div>
</div>
