<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA KENDARAAN</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Kd Motor <?php echo form_error('kd_motor') ?></td><td><input type="text" class="form-control" name="kd_motor" id="kd_motor" placeholder="Kd Motor" value="<?php echo $kd_motor; ?>" /></td></tr>
	    <tr><td width='200'>Nama Kendaraan <?php echo form_error('nama_kendaraan') ?></td><td><input type="text" class="form-control" name="nama_kendaraan" id="nama_kendaraan" placeholder="Nama Kendaraan" value="<?php echo $nama_kendaraan; ?>" /></td></tr>
	    <tr>
            <td width='200'>Jenis Kendaraan <?php echo form_error('jenis_kendaraan_id') ?></td>
            <td><select name="jenis_kendaraan_id" class="form-control">
                <option value="">-- Pilih -- </option>
                <?php foreach ($jenis as $key => $data) { ?>
                  <?php if ($jenis_kendaraan_id == $data->jenis_kendaraan_id) { ?>
                    <option value="<?php echo $data->jenis_kendaraan_id ?>" selected><?php echo $data->nama_jenis_kendaraan ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $data->jenis_kendaraan_id ?>"><?php echo $data->nama_jenis_kendaraan ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
          </tr>

          <tr>
            <td width='200'>merek <?php echo form_error('merek_id') ?></td>
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
                            <img src="<?php echo base_url();?>assets/img/kendaraan/<?=$photo?>" width="200" height="150"></img>
                            <input type="hidden" name="photo_lama" value="<?=$photo?>">
                            <p style="color: red">Note :Pilih photo Jika Ingin Merubah photo</p>
                            <input type="file" class="form-control" name="photo" id="photo" placeholder="photo" value="" onchange="return validasiEkstensi()" />
                            <!-- <div id="preview"></div> -->
                        </td>

                    </tr>

                    
                  </div>
                  <?php } ?>


	    <tr><td></td><td><input type="hidden" name="kendaraan_id" value="<?php echo $kendaraan_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('kendaraan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>