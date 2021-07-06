<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA MENU</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Menu <?php echo form_error('menu') ?></td><td><input type="text" class="form-control" name="menu" id="menu" placeholder="Menu" value="<?php echo $menu; ?>" /></td></tr>
	    <tr><td width='200'>Icon <?php echo form_error('icon') ?></td><td><input type="text" class="form-control" name="icon" id="icon" placeholder="Icon" value="<?php echo $icon; ?>" /></td></tr>
	    <tr><td width='200'>Urutan <?php echo form_error('urutan') ?></td><td><input type="number" class="form-control" name="urutan" id="urutan" placeholder="Urutan" value="<?php echo $urutan; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('menu') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>