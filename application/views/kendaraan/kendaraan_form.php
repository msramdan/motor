<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA KENDARAAN</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Kd Motor <?php echo form_error('kd_motor') ?></td><td><input type="text" class="form-control" name="kd_motor" id="kd_motor" placeholder="Kd Motor" value="<?php echo $kd_motor; ?>" /></td></tr>
	    <tr><td width='200'>Nama Kendaraan <?php echo form_error('nama_kendaraan') ?></td><td><input type="text" class="form-control" name="nama_kendaraan" id="nama_kendaraan" placeholder="Nama Kendaraan" value="<?php echo $nama_kendaraan; ?>" /></td></tr>
	    <tr><td width='200'>Jenis Kendaraan Id <?php echo form_error('jenis_kendaraan_id') ?></td><td><input type="text" class="form-control" name="jenis_kendaraan_id" id="jenis_kendaraan_id" placeholder="Jenis Kendaraan Id" value="<?php echo $jenis_kendaraan_id; ?>" /></td></tr>
	    <tr><td width='200'>Merek Id <?php echo form_error('merek_id') ?></td><td><input type="text" class="form-control" name="merek_id" id="merek_id" placeholder="Merek Id" value="<?php echo $merek_id; ?>" /></td></tr>
	    <tr><td width='200'>No Stnk <?php echo form_error('no_stnk') ?></td><td><input type="text" class="form-control" name="no_stnk" id="no_stnk" placeholder="No Stnk" value="<?php echo $no_stnk; ?>" /></td></tr>
	    <tr><td width='200'>No Bpkb <?php echo form_error('no_bpkb') ?></td><td><input type="text" class="form-control" name="no_bpkb" id="no_bpkb" placeholder="No Bpkb" value="<?php echo $no_bpkb; ?>" /></td></tr>
	    
        <tr><td width='200'>Deskripsi <?php echo form_error('deskripsi') ?></td><td> <textarea class="form-control" rows="3" name="deskripsi" id="deskripsi" placeholder="Deskripsi"><?php echo $deskripsi; ?></textarea></td></tr>
	    <tr><td width='200'>Photo <?php echo form_error('photo') ?></td><td><input type="text" class="form-control" name="photo" id="photo" placeholder="Photo" value="<?php echo $photo; ?>" /></td></tr>
	    <tr><td width='200'>Status <?php echo form_error('status') ?></td><td><input type="text" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="kendaraan_id" value="<?php echo $kendaraan_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('kendaraan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>