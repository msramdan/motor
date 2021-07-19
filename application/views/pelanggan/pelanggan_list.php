
            <div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA PELANGGAN</h3>
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
        echo show_button($menu_accessed, 'export'); ?></div>
            </div>
            <div class='col-md-3'>
            <form action="<?php echo site_url('pelanggan/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('pelanggan'); ?>" class="btn btn-default">Reset</a>
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
		<th>No Ktp</th>
		<th>No Kk</th>
		<th>Nama Pelanggan</th>
		<th>No Hp Pelanggan</th>
		<th>Jenis Kelamin</th>
		<th>Alamat Ktp</th>
		<th>Alamat Domisili</th>
		<th>Nama Saudara</th>
		<th>Alamat Saudara</th>
		<th>No Hp Saudara</th>
		<th>Action</th>
            </tr><?php
            foreach ($pelanggan_data as $pelanggan)
            {
                ?>
                <tr>
			<td width="10px"><?php echo ++$start ?></td>
			<td><?php echo $pelanggan->no_ktp ?></td>
			<td><?php echo $pelanggan->no_kk ?></td>
			<td><?php echo $pelanggan->nama_pelanggan ?></td>
			<td><?php echo $pelanggan->no_hp_pelanggan ?></td>
			<td><?php echo $pelanggan->jenis_kelamin ?></td>
			<td><?php echo $pelanggan->alamat_ktp ?></td>
			<td><?php echo $pelanggan->alamat_domisili ?></td>
			<td><?php echo $pelanggan->nama_saudara ?></td>
			<td><?php echo $pelanggan->alamat_saudara ?></td>
			<td><?php echo $pelanggan->no_hp_saudara ?></td>
			<td style="text-align:center" width="200px">
				<?php 
                echo anchor(site_url('pelanggan/upload/'.encrypt_url($pelanggan->pelanggan_id)),'<i class="fa fa-upload" aria-hidden="true"></i>','class="btn btn-warning btn-sm"'); //still finding out?> 
                <?php echo show_button($menu_accessed, 'read',encrypt_url($pelanggan->pelanggan_id)); ?>
                <?php echo show_button($menu_accessed, 'update',encrypt_url($pelanggan->pelanggan_id)); ?>
                <?php echo show_button($menu_accessed, 'delete',encrypt_url($pelanggan->pelanggan_id)); ?>
			</td>
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
