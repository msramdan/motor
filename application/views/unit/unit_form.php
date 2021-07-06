<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA UNIT</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        


      <tr>
            <td width='200'>grup <?php echo form_error('grup_id') ?></td>
            <td><select name="grup_id" class="form-control">
                <option value="">-- Pilih -- </option>
                <?php foreach ($grup as $key => $data) { ?>
                  <?php if ($grup_id == $data->grup_id) { ?>
                    <option value="<?php echo $data->grup_id ?>" selected><?php echo $data->nama_grup ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $data->grup_id ?>"><?php echo $data->nama_grup ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
          </tr>

	    <tr><td width='200'>Nama Unit <?php echo form_error('nama_unit') ?></td><td><input type="text" class="form-control" name="nama_unit" id="nama_unit" placeholder="Nama Unit" value="<?php echo $nama_unit; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('unit') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>