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
            
<table class='table table-bordered'>        
    <input type="hidden" class="form-control input-validation no-copas-allowed" name="unit_id" id="unit_id" value="<?= $this->session->userdata('unit_id') ?>" placeholder="" />    
	    <tr><td width='200'>No Ktp <?php echo form_error('no_ktp') ?></td><td><input type="text" class="form-control" name="no_ktp" id="no_ktp" placeholder="No Ktp" value="<?php echo $no_ktp; ?>" /></td></tr>
	    <tr><td width='200'>No Kk <?php echo form_error('no_kk') ?></td><td><input type="text" class="form-control" name="no_kk" id="no_kk" placeholder="No Kk" value="<?php echo $no_kk; ?>" /></td></tr>
	    <tr><td width='200'>Nama Pelanggan <?php echo form_error('nama_pelanggan') ?></td><td><input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" placeholder="Nama Pelanggan" value="<?php echo $nama_pelanggan; ?>" /></td></tr>
	    <tr><td width='200'>No Hp Pelanggan <?php echo form_error('no_hp_pelanggan') ?></td><td><input type="text" class="form-control" name="no_hp_pelanggan" id="no_hp_pelanggan" placeholder="No Hp Pelanggan" value="<?php echo $no_hp_pelanggan; ?>" /></td></tr>
	    <tr>
            <td width='200'>Jenis Kelamin <?php echo form_error('jenis_kelamin') ?></td>
            <td><select name="jenis_kelamin" class="form-control" value="<?= $jenis_kelamin ?>">
                <option value="">- Pilih -</option>
                <option value="Laki Laki" <?php echo $jenis_kelamin == 'Laki Laki' ? 'selected' : 'null' ?>>Laki Laki</option>
                <option value="Perempuan" <?php echo $jenis_kelamin == 'Perempuan' ? 'selected' : 'null' ?>>Perempuan</option>
              </select>
            </td>
          </tr>
	    
        <tr><td width='200'>Alamat Ktp <?php echo form_error('alamat_ktp') ?></td><td> <textarea class="form-control" rows="3" name="alamat_ktp" id="alamat_ktp" placeholder="Alamat Ktp"><?php echo $alamat_ktp; ?></textarea></td></tr>
	    
        <tr><td width='200'>Alamat Domisili <?php echo form_error('alamat_domisili') ?></td><td> <textarea class="form-control" rows="3" name="alamat_domisili" id="alamat_domisili" placeholder="Alamat Domisili"><?php echo $alamat_domisili; ?></textarea></td></tr>
	    <tr><td width='200'>Nama Saudara <?php echo form_error('nama_saudara') ?></td><td><input type="text" class="form-control" name="nama_saudara" id="nama_saudara" placeholder="Nama Saudara" value="<?php echo $nama_saudara; ?>" /></td></tr>
	    
        <tr><td width='200'>Alamat Saudara <?php echo form_error('alamat_saudara') ?></td><td> <textarea class="form-control" rows="3" name="alamat_saudara" id="alamat_saudara" placeholder="Alamat Saudara"><?php echo $alamat_saudara; ?></textarea></td></tr>
	    <tr><td width='200'>No Hp Saudara <?php echo form_error('no_hp_saudara') ?></td><td><input type="text" class="form-control" name="no_hp_saudara" id="no_hp_saudara" placeholder="No Hp Saudara" value="<?php echo $no_hp_saudara; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="pelanggan_id" value="<?php echo $pelanggan_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('pelanggan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>