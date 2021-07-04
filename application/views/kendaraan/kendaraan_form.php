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
            
<table class='table table-bordered'>        

	    


      <?php if ($this->uri->segment(2) == 'create' || $this->uri->segment(2) == 'create_action' ) { ?>
                     <tr><td width='200'>Kd Pembelian <?php echo form_error('kd_pembelian') ?></td><td><input type="text" class="form-control" name="kd_pembelian" id="kd_pembelian" placeholder="Kd Pembelian" readonly="" value="B<?= $kodeunik ?>"  /></td></tr>
                  <?php }else{ ?>
                      <tr><td width='200'>Kd Pembelian <?php echo form_error('kd_pembelian') ?></td><td><input type="text" class="form-control" name="kd_pembelian" id="kd_pembelian" placeholder="Kd Pembelian" readonly="" value="<?php echo $kd_pembelian ?>"  /></td></tr>
                  <?php } ?>

	    

            <?php if ($this->uri->segment(2) == 'create' || $this->uri->segment(2) == 'create_action' ) { ?>
                     <tr><td width='200'>Kode Item <?php echo form_error('kd_kendaraan') ?></td><td><input type="text" class="form-control" name="kd_kendaraan" readonly="" id="kd_kendaraan" placeholder="Kode Item" value="BRG<?php echo sprintf("%04s", $kode_barang) ?>" /></td></tr>
                  <?php }else{ ?>
                      <tr><td width='200'>Kode Item <?php echo form_error('kd_kendaraan') ?></td><td><input type="text" class="form-control" name="kd_kendaraan" readonly="" id="kd_kendaraan" placeholder="Kode Item" value="<?php echo $kd_kendaraan; ?>" /></td></tr>
                  <?php } ?>

	    <tr><td width='200'>Nama Item <?php echo form_error('nama_kendaraan') ?></td><td><input type="text" class="form-control" name="nama_kendaraan" id="nama_kendaraan" placeholder="Nama Item" value="<?php echo $nama_kendaraan; ?>" /></td></tr>
	    <tr>

        <tr>
            <td width='200'>Agen <?php echo form_error('agen_id') ?></td>
            <td><select name="agen_id" class="form-control">
                <option value="">-- Pilih -- </option>
                <?php foreach ($agen as $key => $data) { ?>
                  <?php if ($agen_id == $data->agen_id) { ?>
                    <option value="<?php echo $data->agen_id ?>" selected><?php echo $data->nama_agen ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $data->agen_id ?>"><?php echo $data->nama_agen ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
          </tr>

          <tr>
            <td width='200'>Kategori Item <?php echo form_error('kategori_id') ?></td>
            <td><select name="kategori_id" class="form-control">
                <option value="">-- Pilih -- </option>
                <?php foreach ($kategori as $key => $data) { ?>
                  <?php if ($kategori_id == $data->kategori_id) { ?>
                    <option value="<?php echo $data->kategori_id ?>" selected><?php echo $data->nama_kategori ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $data->kategori_id ?>"><?php echo $data->nama_kategori ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
          </tr>


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
            <td width='200'>Type <?php echo form_error('type_id') ?></td>
            <td><select name="type_id" class="form-control">
                <option value="">-- Pilih -- </option>
                <?php foreach ($type as $key => $data) { ?>
                  <?php if ($type_id == $data->type_id) { ?>
                    <option value="<?php echo $data->type_id ?>" selected><?php echo $data->nama_type ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $data->type_id ?>"><?php echo $data->nama_type ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
          </tr>

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

	    <tr><td width='200'>No Stnk <?php echo form_error('no_stnk') ?></td><td><input type="text" class="form-control" name="no_stnk" id="no_stnk" placeholder="No Stnk" value="<?php echo $no_stnk; ?>" /></td></tr>
	    <tr><td width='200'>No Bpkb <?php echo form_error('no_bpkb') ?></td><td><input type="text" class="form-control" name="no_bpkb" id="no_bpkb" placeholder="No Bpkb" value="<?php echo $no_bpkb; ?>" /></td></tr>
	    
        <tr><td width='200'>Deskripsi <?php echo form_error('deskripsi') ?></td><td> <textarea class="form-control" rows="3" name="deskripsi" id="deskripsi" placeholder="Deskripsi"><?php echo $deskripsi; ?></textarea></td></tr>
	    <tr><td width='200'>Harga Perolehan <?php echo form_error('harga_beli') ?></td><td><input type="text" class="form-control" name="harga_beli" id="harga_beli" placeholder="Harga Beli" value="<?php echo $harga_beli; ?>" /></td></tr>

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

	    <input type="hidden" class="form-control" name="status" value="Ready" id="status" placeholder="Status" value="<?php echo $status; ?>"

	    <tr><td></td><td><input type="hidden" name="kendaraan_id" value="<?php echo $kendaraan_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('kendaraan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>