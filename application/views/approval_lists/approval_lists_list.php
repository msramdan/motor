
            <div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA APPROVAL_LISTS</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
            <div class='row'>
            <div class='col-md-9'>
            <div style="padding-bottom: 10px;"></div>
            </div>
            <div class='col-md-3'>
            <form action="<?php echo site_url('approval_lists/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('approval_lists'); ?>" class="btn btn-default">Reset</a>
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
		<th>Invoice Id</th>
		<th>Approve By</th>
		<th>Approval Status</th>
        <th>Jenis Tindakan</th>
		<th>Keterangan</th>
		<th>Komentar</th>
		<th>Action</th>
            </tr><?php
            foreach ($approval_lists_data as $approval_lists)
            {
                ?>
                <tr>
			<td width="10px"><?php echo ++$start ?></td>
			<td><?php echo $approval_lists->invoice_id ?></td>
			<td><?php
                $split = json_decode($approval_lists->approve_by, true);
            foreach($split as $key => $v) {
                echo '<label class="label label-primary">'.$key.'</label>';
            } ?></td>
			<td><?php echo $approval_lists->approval_status ?></td>
            <td><?php echo $approval_lists->jenis_tindakan ?></td>
			<td><?php

                if ($approval_lists->jenis_tindakan === 'Pengajuan Diskon') {
                    ?>
                    Pengajuan Diskon untuk denda cicilan
                    <?php
                }else{
                    
                    echo $approval_lists->keterangan;
                    
                }
                ?></td>
			<td><?php echo $approval_lists->komentar ?></td>
			<td style="text-align:center" width="200px">
				<?php
                echo show_button($menu_accessed, 'read', $approval_lists->approval_id.'/'.$approval_lists->invoice_id);
                
				//echo anchor(site_url('Approval_lists/read/'.$approval_lists->invoice_id),'<i class="fa fa-eye" aria-hidden="true"></i>','class="btn btn-success btn-sm"'); 
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