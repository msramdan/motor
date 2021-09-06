
            <div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA MEREK</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
            <div class='row'>
            <div class='col-md-9'>
            <div style="padding-bottom: 10px;">
        <?php   echo show_button($menu_accessed, 'create');
                echo show_button($menu_accessed, 'export');?></div>
            </div>
            <div class='col-md-3'>
            <form action="<?php echo site_url('merek/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('merek'); ?>" class="btn btn-default">Reset</a>
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
		<th>Nama Merek</th>
		<th>Action</th>
            </tr><?php
            foreach ($merek_data as $merek)
            {
                ?>
                <tr>
			<td width="10px"><?php echo ++$start ?></td>
			<td><?php echo $merek->nama_merek ?></td>
			<td style="text-align:center" width="200px">
                <?php echo show_button($menu_accessed, 'read',$merek->merek_id); ?>
                <?php echo show_button($menu_accessed, 'update',$merek->merek_id); ?>
				<?php echo show_button($menu_accessed, 'delete',$merek->merek_id); ?>
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
