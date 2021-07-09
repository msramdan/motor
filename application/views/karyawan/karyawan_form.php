<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA KARYAWAN</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Nama Karyawan <?php echo form_error('nama_karyawan') ?></td><td><input type="text" class="form-control" name="nama_karyawan" id="nama_karyawan" placeholder="Nama Karyawan" value="<?php echo $nama_karyawan; ?>" /></td></tr>
	    <tr><td width='200'>No Ktp Karyawan <?php echo form_error('no_ktp_karyawan') ?></td><td><input type="text" class="form-control" name="no_ktp_karyawan" id="no_ktp_karyawan" placeholder="No Ktp Karyawan" value="<?php echo $no_ktp_karyawan; ?>" /></td></tr>
	    <tr><td width='200'>No Hp Karyawan <?php echo form_error('no_hp_karyawan') ?></td><td><input type="text" class="form-control" name="no_hp_karyawan" id="no_hp_karyawan" placeholder="No Hp Karyawan" value="<?php echo $no_hp_karyawan; ?>" /></td></tr>

	      <tr>
            <td width='200'>Jenis Kelamin <?php echo form_error('jenis_kelamin') ?></td>
            <td><select name="jenis_kelamin" class="form-control" value="<?= $jenis_kelamin ?>">
                <option value="">- Pilih -</option>
                <option value="Laki Laki" <?php echo $jenis_kelamin == 'Laki Laki' ? 'selected' : 'null' ?>>Laki Laki</option>
                <option value="Perempuan" <?php echo $jenis_kelamin == 'Perempuan' ? 'selected' : 'null' ?>>Perempuan</option>
              </select>
            </td>
          </tr>

          <tr>
            <td width='200'>Pendidikan <?php echo form_error('pendidikan') ?></td>
            <td><select name="pendidikan" class="form-control" value="<?= $pendidikan ?>">
                <option value="">- Pilih -</option>
                <option value="SD/MI" <?php echo $pendidikan == 'SD/MI' ? 'selected' : 'null' ?>>SD/MI</option>
                <option value="SMP/MTS" <?php echo $pendidikan == 'SMP/MTS' ? 'selected' : 'null' ?>>SMP/MTS</option>
                <option value="SMA/SMK" <?php echo $pendidikan == 'SMA/SMK' ? 'selected' : 'null' ?>>SMA/SMK</option>
                <option value="S1" <?php echo $pendidikan == 'S1' ? 'selected' : 'null' ?>>S1</option>
                <option value="S2" <?php echo $pendidikan == 'S2' ? 'selected' : 'null' ?>>S2</option>
                <option value="S3" <?php echo $pendidikan == 'S3' ? 'selected' : 'null' ?>>S3</option>
              </select>
            </td>
          </tr>
	    
        <tr><td width='200'>Alamat <?php echo form_error('alamat') ?></td><td> <textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Alamat"><?php echo $alamat; ?></textarea></td></tr>

        <input type="hidden" class="form-control input-validation no-copas-allowed" name="unit_id" id="unit_id" value="<?= $this->session->userdata('unit_id') ?>" placeholder="" />


       <?php if ($this->uri->segment(2) == 'create' || $this->uri->segment(2) == 'create_action' ) { ?>
                     <tr><td width='200'>photo <?php echo form_error('photo') ?></td><td><input type="file" class="form-control" name="photo" id="photo" placeholder="photo" required="" value="" onchange="return validasiEkstensi()" />
                        <!-- <div id="preview"></div> -->
                     </td></tr>
                  <?php }else{ ?>
                  <div class="form-group">
                    

                    <tr>
                        <td width='200'>photo <?php echo form_error('photo') ?></td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/karyawan/<?=$photo?>" width="200" height="150"></img>
                            <input type="hidden" name="photo_lama" value="<?=$photo?>">
                            <p style="color: red">Note :Pilih photo Jika Ingin Merubah photo</p>
                            <input type="file" class="form-control" name="photo" id="photo" placeholder="photo" value="" onchange="return validasiEkstensi()" />
                            <!-- <div id="preview"></div> -->
                        </td>

                    </tr>

                    
                  </div>
                  <?php } ?>

	    <tr><td></td><td><input type="hidden" name="karyawan_id" value="<?php echo $karyawan_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('karyawan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>

<script type="text/javascript">
  function validasiEkstensi(){
    var inputFile = document.getElementById('photo');
    var pathFile = inputFile.value;
    var ekstensiOk = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if(!ekstensiOk.exec(pathFile)){
        alert('Silakan upload file yang memiliki ekstensi .jpeg/.jpg/.png');
        inputFile.value = '';
        return false;
    }else{
        // Preview photo
        if (inputFile.files && inputFile.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').innerHTML = '<iframe src="'+e.target.result+'" style="height:400px; width:600px"/>';
            };
            reader.readAsDataURL(inputFile.files[0]);
        }
    }
}
</script>