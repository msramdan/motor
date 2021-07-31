<div class="page-title">
                          <div class="title_left">
                          <h3>LIST PEMBAYARAN CASH</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
            <div class='row'>
            <!-- <div class='col-md-9'>
            <div style="padding-bottom: 10px;">
        <?php echo anchor(site_url('mitra/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?>
		<?php echo anchor(site_url('mitra/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?></div>
            </div> -->
            <div class='col-md-3'>
            <form action="<?php echo site_url('onetimep/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('onetimep'); ?>" class="btn btn-default">Reset</a>
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
            </tr>
            <?php
            foreach ($otps as $otp)
            {
                ?>
                <tr>
			<td width="10px"><?php echo ++$start ?></td>
			<td><?php echo $otp->invoice ?></td>
			<td><?php echo $otp->nama_pelanggan ?></td>
			<td><?php echo $otp->nama_item ?></td>
			<td><?php echo $otp->type_sale ?></td>
			<td><?php echo $otp->tanggal_sale ?></td>
			<td><?php echo $otp->nama_user ?></td>
            <td><?php
                if($otp->status_sale === 'Selesai')
                {?>
                    <label class="label label-success">Selesai</label>
                <?php }
                if ($otp->status_sale === 'Belum Dibayar') {
                    ?>
                    <label class="label label-danger">Belum Dibayar</label>
                <?
                }
                ?></td>
			<td style="text-align:center" width="200px">
				<a href="<?php echo base_url().'Onetimep/paymentformfor?inv='.$otp->invoice ?>" class="btn btn-warning btn-sm">Bayar</a>
				<?php
				// echo show_button($menu_accessed, 'read', $otp->sale_id);
    //             echo show_button($menu_accessed, 'delete', $otp->sale_id);
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