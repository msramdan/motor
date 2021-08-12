
            <div class="page-title">
                          <div class="title_left">
                          <h3>LIST CICILAN</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
            <div class='row'>
            <div class='col-md-9'>
            <div style="padding-bottom: 10px;">
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
        		<th>Status Angsuran</th>
                <th>Action</th>
            </tr><?php

            if ($sale_detail_data) {
                foreach ($sale_detail_data as $sale_detail)
                {
                    if ($sale_detail->status_sale !== 'Dalam Review') {
                        ?>
                    <tr>
                        <td width="10px"><?php echo ++$start ?></td>
                        <td><?php echo $sale_detail->saleid ?></td>
                        <td class="project_progress">
                           <div class="progress">
                              <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar"
                              aria-valuenow="<?php echo $sale_detail->total_dibayar; ?>" aria-valuemin="0" aria-valuemax="<?php echo $sale_detail->total_angsuran; ?>" style="width:<?php echo intval($sale_detail->total_dibayar)/ intval($sale_detail->total_angsuran) * 100; ?>%">
                                <?php echo round(intval($sale_detail->total_dibayar)/ intval($sale_detail->total_angsuran) * 100, 2); ?>%
                              </div>
                            </div>
                            <small><?php echo $sale_detail->total_dibayar; ?>/<?php echo $sale_detail->total_angsuran; ?> Terbayar</small>
                        </td>
                        <td style="text-align:center" width="200px">
                            <?php 
                            echo anchor(site_url('cicilan/detail/'.$sale_detail->saleid),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-primary btn-sm"'); 
                            ?>
                            <a class="btn btn-info btn-sm" href="<?php echo base_url().'cicilan/kartu_piutang?invoice='.$sale_detail->saleid ?>"><i class="fa fa-print"></i></a>
                        </td>
                    </tr>
                    <?php
                    }
                }
            } else {
                ?>
                    <tr><td colspan="4" align="center" style="padding: 2em 0">Tidak ada data cicilan, mulai dengan menambahkan data penjualan</td></tr>
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