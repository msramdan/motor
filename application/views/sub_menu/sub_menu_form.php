<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA SUB_MENU</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered'>
      <tr>
            <td width='200'>Menu <?php echo form_error('menu_id') ?></td>
            <td><select name="menu_id" class="form-control">
                <option value="">-- Pilih -- </option>
                <?php foreach ($menu as $key => $data) { ?>
                  <?php if ($menu_id == $data->menu_id) { ?>
                    <option value="<?php echo $data->menu_id ?>" selected><?php echo $data->menu ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $data->menu_id ?>"><?php echo $data->menu ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
	    <tr><td width='200'>Nama Sub Menu <?php echo form_error('nama_sub_menu') ?></td><td><input type="text" class="form-control" name="nama_sub_menu" id="nama_sub_menu" placeholder="Nama Sub Menu" value="<?php echo $nama_sub_menu; ?>" /></td></tr>
	    <tr><td width='200'>Url <?php echo form_error('url') ?></td><td><input type="text" class="form-control" name="url" id="url" placeholder="Url" value="<?php echo $url; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="sub_menu_id" value="<?php echo $sub_menu_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('menu') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>