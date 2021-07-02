<div class="page-title">
	<div class="title_left">
		<h3>KELOLA DATA USER</h3>
	</div>
	<div class="clearfix"></div>
		<?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
    		<strong>'.$this->session->userdata('message').'</strong>
		</div>' : ''; ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        			<div class="box-body">
            			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
							<table class='table table-bordered'>
	    						<tr>
	    							<td width='200'>
	    								Nama Lengkap <?php echo form_error('nama_user') ?>
    								</td>
	    							<td>
	    								<input type="text" class="form-control" name="nama_user" id="nama_user" placeholder="Nama User" value="<?php echo $nama_user; ?>" />
	    							</td>
	    						</tr>
	    						


	    						<tr>
	    							<td width='200'>Email <?php echo form_error('email') ?></td><td><input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" /></td>
	    						</tr>
	    						<tr>
	    							<td width='200'>No Hp User <?php echo form_error('no_hp_user') ?></td><td><input type="text" class="form-control" name="no_hp_user" id="no_hp_user" placeholder="No Hp User" value="<?php echo $no_hp_user; ?>" /></td>
	    						</tr>
	    
        						<tr>
        							<td width='200'>Alamat User <?php echo form_error('alamat_user') ?></td><td> <textarea class="form-control" rows="3" name="alamat_user" id="alamat_user" placeholder="Alamat User"><?php echo $alamat_user; ?></textarea></td>
        						</tr>

			              <?php if ($this->uri->segment(2) == 'create' || $this->uri->segment(2) == 'create_action' ) { ?>
			                     <tr><td width='200'>photo <?php echo form_error('photo') ?></td><td><input type="file" class="form-control" name="photo" id="photo" placeholder="photo" required="" value="" onchange="return validasiEkstensi()" />
			                        <!-- <div id="preview"></div> -->
			                     </td></tr>
			                  <?php }else{ ?>
			                  <div class="form-group">
			                    

			                    <tr>
			                        <td width='200'>photo <?php echo form_error('photo') ?></td>
			                        <td>
			                            <img src="<?php echo base_url();?>assets/img/user/<?=$photo?>" width="200" height="150"></img>
			                            <input type="hidden" name="photo_lama" value="<?=$photo?>">
			                            <p style="color: red">Note :Pilih photo Jika Ingin Merubah photo</p>
			                            <input type="file" class="form-control" name="photo" id="photo" placeholder="photo" value="" onchange="return validasiEkstensi()" />
			                            <!-- <div id="preview"></div> -->
			                        </td>

			                    </tr>

			                    
			                  </div>
			                  <?php } ?>
				    



				    <tr>
				    	<td>
				    		
				    	</td>
				    	<td>
				    		<input type="hidden" name="user_id" value="<?php echo $user_id; ?>" /> 
				    		<button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
				    		<a href="<?php echo site_url('user') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
				    	</td>
				    </tr>
					</table>
				</form>
			</div>
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