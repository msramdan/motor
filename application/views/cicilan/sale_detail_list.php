
            <div class="page-title">
                          <div class="title_left">
                          <h3>DATA CICILAN</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
            <div class='row'>
            <div class='col-md-9'>
            <div style="padding-bottom: 10px;">
        <?php echo anchor(site_url('sale_detail/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?>
		<?php echo anchor(site_url('sale_detail/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?>
		<?php echo anchor(site_url('sale_detail/word'), '<i class="fa fa-file-word-o" aria-hidden="true"></i> Export Ms Word', 'class="btn btn-primary btn-sm"'); ?></div>
            </div>
            <div class='col-md-3'>
            <form action="<?php echo site_url('cicilan/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('cicilan'); ?>" class="btn btn-default">Reset</a>
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
		<th>Total Angsuran</th>
        <th>Action</th>
            </tr><?php
            foreach ($sale_detail_data as $sale_detail)
            {
                ?>
                <tr>
			<td width="10px"><?php echo ++$start ?></td>
			<td><?php echo $sale_detail->saleid ?></td>
            <td class="project_progress">
               <div class="progress">
                  <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar"
                  aria-valuenow="<?php echo $sale_detail->total_dibayar; ?>" aria-valuemin="0" aria-valuemax="<?php echo $sale_detail->total_angsuran; ?>" style="width:<?php echo intval($sale_detail->total_dibayar)/ intval($sale_detail->total_angsuran) * 100; ?>%">
                    <?php echo intval($sale_detail->total_dibayar)/ intval($sale_detail->total_angsuran) * 100; ?>%
                  </div>
                </div>
                <small><?php echo $sale_detail->total_dibayar; ?>/<?php echo $sale_detail->total_angsuran; ?> Terbayar</small>
            </td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('cicilan/read/'.$sale_detail->saleid),'<i class="fa fa-eye" aria-hidden="true"></i>','class="btn btn-success btn-sm"'); 
				echo '  '; 
				echo anchor(site_url('cicilan/update/'.$sale_detail->saleid),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-primary btn-sm"'); 
				echo '  '; 
				echo anchor(site_url('cicilan/delete/'.$sale_detail->saleid),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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