<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA AGEN</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Nama Agan <?php echo form_error('nama_agan') ?></td><td><input type="text" class="form-control" name="nama_agan" id="nama_agan" placeholder="Nama Agan" value="<?php echo $nama_agan; ?>" /></td></tr>
	    <tr><td width='200'>No Hp Agen <?php echo form_error('no_hp_agen') ?></td><td><input type="text" class="form-control" name="no_hp_agen" id="no_hp_agen" placeholder="No Hp Agen" value="<?php echo $no_hp_agen; ?>" /></td></tr>
	    
        <tr><td width='200'>Alamat <?php echo form_error('alamat') ?></td><td> <textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Alamat"><?php echo $alamat; ?></textarea></td></tr>
	    
        <tr><td width='200'>Deskripsi <?php echo form_error('deskripsi') ?></td><td> <textarea class="form-control" rows="3" name="deskripsi" id="deskripsi" placeholder="Deskripsi"><?php echo $deskripsi; ?></textarea></td></tr>
	    <tr><td></td><td><input type="hidden" name="agen_id" value="<?php echo $agen_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('agen') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>