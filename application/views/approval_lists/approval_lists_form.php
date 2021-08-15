<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA APPROVAL_LISTS</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Invoice Id <?php echo form_error('invoice_id') ?></td><td><input type="text" class="form-control" name="invoice_id" id="invoice_id" placeholder="Invoice Id" value="<?php echo $invoice_id; ?>" /></td></tr>
	    <tr><td width='200'>Approve By <?php echo form_error('approve_by') ?></td><td><input type="text" class="form-control" name="approve_by" id="approve_by" placeholder="Approve By" value="<?php echo $approve_by; ?>" /></td></tr>
	    <tr><td width='200'>Approval Status <?php echo form_error('approval_status') ?></td><td><input type="text" class="form-control" name="approval_status" id="approval_status" placeholder="Approval Status" value="<?php echo $approval_status; ?>" /></td></tr>
	    
        <tr><td width='200'>Keterangan <?php echo form_error('keterangan') ?></td><td> <textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea></td></tr>
	    
        <tr><td width='200'>Komentar <?php echo form_error('komentar') ?></td><td> <textarea class="form-control" rows="3" name="komentar" id="komentar" placeholder="Komentar"><?php echo $komentar; ?></textarea></td></tr>
	    <tr><td></td><td><input type="hidden" name="approval_id" value="<?php echo $approval_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('approval_lists') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>