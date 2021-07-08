<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA INFO</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Title <?php echo form_error('title') ?></td><td><input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?php echo $title; ?>" /></td></tr>
	    
        <tr><td width='200'>Desk <?php echo form_error('desk') ?></td><td> <textarea class="form-control" rows="3" name="desk" id="desk" placeholder="Desk"><?php echo $desk; ?></textarea></td></tr>
	    <tr><td></td><td><input type="hidden" name="info_id" value="<?php echo $info_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('info') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>