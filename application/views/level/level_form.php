<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA LEVEL</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered'>        

	    <tr><td width='200'>Nama Level <?php echo form_error('nama_level') ?></td><td><input type="text" class="form-control" name="nama_level" id="nama_level" placeholder="Nama Level" value="<?php echo $nama_level; ?>" /></td></tr>
        <tr><td width='200'></td><td><input type="checkbox" <?php echo $strict_authorization == 0 ? '' :'checked'; ?> class="form-check-input-access" name="strict_authorization" id="strict_authorization" placeholder="Nama Level" value="<?php echo $strict_authorization ?>"> <label for="strict_authorization">Otorisasi Khusus?</label></td></tr>

	    <tr><td></td><td><input type="hidden" name="level_id" value="<?php echo $level_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('level') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>