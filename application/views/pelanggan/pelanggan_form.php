<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA PELANGGAN</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Ktp <?php echo form_error('ktp') ?></td><td><input type="text" class="form-control" name="ktp" id="ktp" placeholder="Ktp" value="<?php echo $ktp; ?>" /></td></tr>
	    <tr><td width='200'>Nama Pelanggan <?php echo form_error('nama_pelanggan') ?></td><td><input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" placeholder="Nama Pelanggan" value="<?php echo $nama_pelanggan; ?>" /></td></tr>
	    <tr><td width='200'>No Hp Pelanggan <?php echo form_error('no_hp_pelanggan') ?></td><td><input type="text" class="form-control" name="no_hp_pelanggan" id="no_hp_pelanggan" placeholder="No Hp Pelanggan" value="<?php echo $no_hp_pelanggan; ?>" /></td></tr>
	    <tr><td width='200'>Jenis Kelamin <?php echo form_error('jenis_kelamin') ?></td><td><input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin" placeholder="Jenis Kelamin" value="<?php echo $jenis_kelamin; ?>" /></td></tr>
	    
        <tr><td width='200'>Alamat <?php echo form_error('alamat') ?></td><td> <textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Alamat"><?php echo $alamat; ?></textarea></td></tr>
	    <tr><td></td><td><input type="hidden" name="pelanggan_id" value="<?php echo $pelanggan_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('pelanggan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>