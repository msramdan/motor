
            <div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA KARYAWAN</h3>
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
        echo show_button($menu_accessed, 'export');?></div>
            </div>
            <div class='col-md-3'>
            <form action="<?php echo site_url('karyawan/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('karyawan'); ?>" class="btn btn-default">Reset</a>
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
		<th>Nama Karyawan</th>
		<th>No Ktp Karyawan</th>
		<th>No Hp Karyawan</th>
		<th>Jenis Kelamin</th>
		<th>Pendidikan</th>
		<th>Alamat</th>
		<th>Unit</th>
		<th>Photo</th>
		<th>Action</th>
            </tr><?php
            foreach ($karyawan_data as $karyawan)
            {
                ?>
                <tr>
			<td width="10px"><?php echo ++$start ?></td>
			<td><?php echo $karyawan->nama_karyawan ?></td>
			<td><?php echo $karyawan->no_ktp_karyawan ?></td>
			<td><?php echo $karyawan->no_hp_karyawan ?></td>
			<td><?php echo $karyawan->jenis_kelamin ?></td>
			<td><?php echo $karyawan->pendidikan ?></td>
			<td><?php echo $karyawan->alamat ?></td>
			<td><?php echo $karyawan->nama_unit ?></td>
            <td><a href="<?php echo base_url(); ?>karyawan/download/<?php echo $karyawan->photo ? $karyawan->photo : 'no-photo-download'; ?>"><i
                                                class="ace-icon fa fa-download"></i> Download Photo</td>
			<td style="text-align:center" width="200px">
				<?php 
                echo show_button($menu_accessed, 'read', $karyawan->karyawan_id);
                echo show_button($menu_accessed, 'update', $karyawan->karyawan_id);
                echo show_button($menu_accessed, 'delete', $karyawan->karyawan_id);
				?>
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