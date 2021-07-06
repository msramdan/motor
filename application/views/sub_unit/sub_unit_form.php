<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA SUB_UNIT</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

      <tr>
            <td width='200'>unit <?php echo form_error('unit_id') ?></td>
            <td><select name="unit_id" class="form-control">
                <option value="">-- Pilih -- </option>
                <?php foreach ($unit as $key => $data) { ?>
                  <?php if ($unit_id == $data->unit_id) { ?>
                    <option value="<?php echo $data->unit_id ?>" selected><?php echo $data->nama_unit ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $data->unit_id ?>"><?php echo $data->nama_unit ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
          </tr>


	    <tr><td width='200'>Nama Sub Unit <?php echo form_error('nama_sub_unit') ?></td><td><input type="text" class="form-control" name="nama_sub_unit" id="nama_sub_unit" placeholder="Nama Sub Unit" value="<?php echo $nama_sub_unit; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="sub_unit_id" value="<?php echo $sub_unit_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('sub_unit') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>