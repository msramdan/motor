<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA MOTOR</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Kd Motor <?php echo form_error('kd_motor') ?></td><td><input type="text" class="form-control" name="kd_motor" id="kd_motor" placeholder="Kd Motor" value="<?php echo $kd_motor; ?>" /></td></tr>
	    <tr><td width='200'>Nama Motor <?php echo form_error('nama_motor') ?></td><td><input type="text" class="form-control" name="nama_motor" id="nama_motor" placeholder="Nama Motor" value="<?php echo $nama_motor; ?>" /></td></tr>
	    <tr>
            <td width='200'>Merek <?php echo form_error('merek_id') ?></td>
            <td><select name="merek_id" class="form-control">
                <option value="">-- Pilih -- </option>
                <?php foreach ($merek as $key => $data) { ?>
                  <?php if ($merek_id == $data->merek_id) { ?>
                    <option value="<?php echo $data->merek_id ?>" selected><?php echo $data->nama_merek ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $data->merek_id ?>"><?php echo $data->nama_merek ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
	    
        <tr><td width='200'>Deskripsi <?php echo form_error('deskripsi') ?></td><td> <textarea class="form-control" rows="3" name="deskripsi" id="deskripsi" placeholder="Deskripsi"><?php echo $deskripsi; ?></textarea></td></tr>
	    <tr><td width='200'>Stok <?php echo form_error('stok') ?></td><td><input type="text" class="form-control" name="stok" id="stok" placeholder="Stok" value="<?php echo $stok; ?>" /></td></tr>

      <?php if ($this->uri->segment(2) == 'create' || $this->uri->segment(2) == 'create_action' ) { ?>
                     <tr><td width='200'>photo <?php echo form_error('photo') ?></td><td><input type="file" class="form-control" name="photo" id="photo" placeholder="photo" required="" value="" onchange="return validasiEkstensi()" />
                        <!-- <div id="preview"></div> -->
                     </td></tr>
                  <?php }else{ ?>
                  <div class="form-group">
                    

                    <tr>
                        <td width='200'>photo <?php echo form_error('photo') ?></td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/motor/<?=$photo?>" width="200" height="150"></img>
                            <input type="hidden" name="photo_lama" value="<?=$photo?>">
                            <p style="color: red">Note :Pilih photo Jika Ingin Merubah photo</p>
                            <input type="file" class="form-control" name="photo" id="photo" placeholder="photo" value="" onchange="return validasiEkstensi()" />
                            <!-- <div id="preview"></div> -->
                        </td>

                    </tr>

                    
                  </div>
                  <?php } ?>





	    <tr><td></td><td><input type="hidden" name="motor_id" value="<?php echo $motor_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('motor') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
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