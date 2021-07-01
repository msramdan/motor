<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA TYPE</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Nama Type <?php echo form_error('nama_type') ?></td><td><input type="text" class="form-control" name="nama_type" id="nama_type" placeholder="Nama Type" value="<?php echo $nama_type; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="type_id" value="<?php echo $type_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('type') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>