<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA SALE_DETAIL</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Sale Id <?php echo form_error('sale_id') ?></td><td><input type="text" class="form-control" name="sale_id" id="sale_id" placeholder="Sale Id" value="<?php echo $sale_id; ?>" /></td></tr>
	    <tr><td width='200'>Pembayaran Ke <?php echo form_error('pembayaran_ke') ?></td><td><input type="text" class="form-control" name="pembayaran_ke" id="pembayaran_ke" placeholder="Pembayaran Ke" value="<?php echo $pembayaran_ke; ?>" /></td></tr>
	    <tr><td width='200'>Status <?php echo form_error('status') ?></td><td><input type="text" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" /></td></tr>
	    <tr><td width='200'>Total Bayar <?php echo form_error('total_bayar') ?></td><td><input type="text" class="form-control" name="total_bayar" id="total_bayar" placeholder="Total Bayar" value="<?php echo $total_bayar; ?>" /></td></tr>
	    <tr><td width='200'>Jatuh Tempo <?php echo form_error('jatuh_tempo') ?></td><td><input type="date" class="form-control" name="jatuh_tempo" id="jatuh_tempo" placeholder="Jatuh Tempo" value="<?php echo $jatuh_tempo; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="sale_detail_id" value="<?php echo $sale_detail_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('sale_detail') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>