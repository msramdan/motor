<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA GRUP</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered'> 

       <?php if ($this->uri->segment(2) == 'create' || $this->uri->segment(2) == 'create_action' ) { ?>
                            <tr>
                                <td width='200'>Kode Grup <?php echo form_error('kd_grup') ?></td>
                                <td><input type="text" class="form-control" name="kd_grup" id="kd_grup"
                                        placeholder="Kode Grup" readonly="" value="<?= $kodeunik ?>" /></td>
                            </tr>
                            <?php }else{ ?>
                            <tr><td width='200'>Kode Grup <?php echo form_error('kd_grup') ?></td><td><input readonly="" type="text" class="form-control" name="kd_grup" id="kd_grup" placeholder="Kode Grup" value="<?php echo $kd_grup; ?>" /></td></tr>
                            <?php } ?>

	    <tr><td width='200'>Nama Grup <?php echo form_error('nama_grup') ?></td><td><input type="text" class="form-control" name="nama_grup" id="nama_grup" placeholder="Nama Grup" value="<?php echo $nama_grup; ?>" /></td></tr>




	    <tr><td></td><td><input type="hidden" name="grup_id" value="<?php echo $grup_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('grup') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>