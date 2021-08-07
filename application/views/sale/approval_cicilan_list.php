
            <div class="page-title">
                          <div class="title_left">
                          <h3>APPROVAL CICILAN</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
            <div class='row'>
            <div class='col-md-9'>
            <div style="padding-bottom: 10px;">
                <?php echo show_button($menu_accessed, 'create') ?>
                <?php echo show_button($menu_accessed, 'export') ?>
            </div>
            </div>
            <div class='col-md-3'>
            <form action="<?php echo site_url('sale/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('sale'); ?>" class="btn btn-default">Reset</a>
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
		<th>Invoice</th>
		<th>Pelanggan</th>
		<th>Item</th>
		<th>Type Sale</th>
		<th>Tanggal Sale</th>
		<th>Penginput</th>
        <th>Status</th>
		<th>Action</th>
            </tr><?php

            if ($sale_data) {
            	foreach ($sale_data as $sale)
            {
                ?>
                <tr>
					<td width="10px"><?php echo ++$start ?></td>
					<td><?php echo $sale->invoice ?></td>
					<td><?php echo $sale->nama_pelanggan ?></td>
					<td><?php echo $sale->nama_item ?></td>
					<td><?php echo $sale->type_sale ?></td>
					<td><?php echo $sale->tanggal_sale ?></td>
					<td><?php echo $sale->nama_user ?></td>
		            <td><?php
		                if ($sale->status_sale === 'Dalam Review') {
		                    ?>
		                    <label class="label label-primary">Menunggu Approval</label>
		                <?php
		                }
		                ?></td>
					<td style="text-align:center" width="200px">
		                <?php
		                
		                    if($sale->status_sale === 'Dalam Review') {
		                        ?>
		                        <a class="btn btn-info btn-sm" href="<?php echo base_url().'Approval_cicilan/detail/'.$sale->invoice ?>"><i class="fa fa-eye"></i></a>
		                        
		                <?php 
		            	}
						echo show_button($menu_accessed, 'read', $sale->sale_id);
		                echo show_button($menu_accessed, 'delete', $sale->sale_id);
						?>
					</td>
				</tr>
		                <?php
		        }
            } else {
            	?>
            	<tr>
            		<td align="center" colspan="9">
            			Tidak ada pengajuan cicilan yang pending disini
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
