<?php if(check_access($level_id,$sub_menu_id) == "checked='checked'"){
    ?>
  <table class="table table-bordered table-striped" id="tabel<?php echo $level_id.$sub_menu_id.$namasubmenu ?>">
    <thead>
      <tr>
        <th style="width: 14%;">Status</th>
        <th colspan="2">Operation</th>
      </tr>
    </thead>
    <tbody>
      <?php
       $coba = check_access($level_id,$sub_menu_id);
       $fetchadditionalaccess = fetchalladditionalaccess($level_id,$sub_menu_id); ?>
      

      <tr>
        <td style="text-align: center;">
          <?php if ($coba=='') { ?>
           <input class="form-check-input-access" type="checkbox" disabled=""
                style="height: 2em;
    width: 2em;"
                data-role="<?= $level_id; ?>"
                data-menu="<?= $sub_menu_id ?>" 
                data-operation="create"
                data-level="<?= $namamenu ?>",
                data-submenu="<?= $namasubmenu ?>">

         <?php }else{ ?>
          <input class="form-check-input-access" type="checkbox" <?= check_access_create($level_id,$sub_menu_id); ?>
                style="height: 2em;
    width: 2em;"
                data-role="<?= $level_id; ?>"
                data-menu="<?= $sub_menu_id ?>" 
                data-operation="create"
                data-level="<?= $namamenu ?>",
                data-submenu="<?= $namasubmenu ?>">
         <?php } ?>
        </td>
        <td colspan="2">
          <label class="" for="customCheck1">create <span><button type="button" class="btn btn-default" data-toggle="tooltip" style="border: none;
    padding: 3px;
    color: #73879c;
    margin-top: 2px;" data-placement="top" title="" data-original-title="Dapat menambahkan record data"><i class="fa fa-question-circle"></i></button></span></label><br>
        </td>
      </tr>

      <tr>
        <td style="text-align: center;">
          <?php if ($coba=='') { ?>
           <input class="form-check-input-access" type="checkbox" disabled=""
                style="height: 2em;
                width: 2em;"
                data-role="<?= $level_id; ?>"
                data-menu="<?= $sub_menu_id ?>" 
                data-operation="read"
                data-level="<?= $namamenu ?>",
                data-submenu="<?= $namasubmenu ?>" onchange="changeAccessfor(this,'read')">

         <?php }else{ ?>
          <input class="form-check-input-access" type="checkbox" <?= check_access_read($level_id,$sub_menu_id); ?>
                style="height: 2em;
    width: 2em;"
                data-role="<?= $level_id; ?>"
                data-menu="<?= $sub_menu_id ?>" 
                data-operation="read"
                data-level="<?= $namamenu ?>",
                data-submenu="<?= $namasubmenu ?>">
         <?php } ?>   
        </td>
        <td colspan="2">
          <label class="" for="customCheck1">read <span><button type="button" class="btn btn-default" data-toggle="tooltip" style="border: none;
    padding: 3px;
    color: #73879c;
    margin-top: 2px;" data-placement="top" title="" data-original-title="Dapat menambahkan melihat record data"><i class="fa fa-question-circle"></i></button></span></label><br>    
        </td>
      </tr>

      <tr>
        <td style="text-align: center;">
          <?php if ($coba=='') { ?>
             <input class="form-check-input-access" type="checkbox" disabled=""
             style="height: 2em;
    width: 2em;"
                  data-role="<?= $level_id; ?>"
                  data-menu="<?= $sub_menu_id ?>" 
                  data-operation="update"
                  data-level="<?= $namamenu ?>",
                  data-submenu="<?= $namasubmenu ?>">

           <?php }else{ ?>
            <input class="form-check-input-access" type="checkbox" <?= check_access_update($level_id,$sub_menu_id); ?>
                  style="height: 2em;
    width: 2em;"
                  data-role="<?= $level_id; ?>"
                  data-menu="<?= $sub_menu_id ?>" 
                  data-operation="update"
                  data-level="<?= $namamenu ?>",
                  data-submenu="<?= $namasubmenu ?>">
           <?php } ?>
        </td>
        <td colspan="2">
          <label class="" for="customCheck1">update <span><button type="button" class="btn btn-default" data-toggle="tooltip" style="border: none;
    padding: 3px;
    color: #73879c;
    margin-top: 2px;" data-placement="top" title="" data-original-title="Dapat melakukan edit pada record data"><i class="fa fa-question-circle"></i></button></span></label><br>
        </td>
      </tr>

      <tr>
        <td style="text-align: center;">
          <?php if ($coba=='') { ?>
           <input class="form-check-input-access" type="checkbox" disabled=""
                style="height: 2em;
    width: 2em;"
                data-role="<?= $level_id; ?>"
                data-menu="<?= $sub_menu_id ?>" 
                data-operation="delete"
                data-level="<?= $namamenu ?>",
                data-submenu="<?= $namasubmenu ?>">

         <?php }else{ ?>
          <input class="form-check-input-access" type="checkbox" <?= check_access_delete($level_id,$sub_menu_id); ?>
                style="height: 2em;
    width: 2em;"
                data-role="<?= $level_id; ?>"
                data-menu="<?= $sub_menu_id ?>" 
                data-operation="delete"
                data-level="<?= $namamenu ?>",
                data-submenu="<?= $namasubmenu ?>">
         <?php } ?>
        </td>
        <td colspan="2">
          <label class="" for="customCheck1">delete <span><button type="button" class="btn btn-default" data-toggle="tooltip" style="border: none;
    padding: 3px;
    color: #73879c;
    margin-top: 2px;" data-placement="top" title="" data-original-title="Dapat melakukan tindakan hapus pada record data"><i class="fa fa-question-circle"></i></button></span></label><br>
        </td>
      </tr>

      <tr>
        <td style="text-align: center;">
          <?php if ($coba=='') { ?>
           <input class="form-check-input-access" type="checkbox" disabled=""
                style="height: 2em;
    width: 2em;"
                data-role="<?= $level_id; ?>"
                data-menu="<?= $sub_menu_id ?>" 
                data-operation="export"
                data-level="<?= $namamenu ?>",
                data-submenu="<?= $namasubmenu ?>">

         <?php }else{ ?>
          <input class="form-check-input-access" type="checkbox" <?= check_access_export($level_id,$sub_menu_id); ?>
                style="height: 2em;
    width: 2em;"
                data-role="<?= $level_id; ?>"
                data-menu="<?= $sub_menu_id ?>" 
                data-operation="export"
                data-level="<?= $namamenu ?>",
                data-submenu="<?= $namasubmenu ?>">
         <?php } ?>
        </td>
        <td colspan="2">
          <label class="" for="customCheck1">export <span><button type="button" class="btn btn-default" data-toggle="tooltip" style="border: none;
    padding: 3px;
    color: #73879c;
    margin-top: 2px;" data-placement="top" title="" data-original-title="Dapat mengambil list record data dalam bentuk file excel"><i class="fa fa-question-circle"></i></button></span></label><br>
        </td>
      </tr>


      <?php 
      $faddaccss = ltrim($fetchadditionalaccess->additional_access,'#');
      if (!$faddaccss == '' || !$faddaccss == NULL) {
		
		$splitaccess = explode('#',$faddaccss);

		foreach($splitaccess as $as){

			?>
						
      	<tr>
      		<?php
      			$splitaccessandstatus = explode(';',$as);
      		?>
      		<td style="text-align: center;">
            <?php
            if ($splitaccessandstatus[2] == 0) {
              ?>
              <input class="form-check-input-access" type="checkbox"
                style="height: 2em;
                width: 2em;"
                data-role="<?= $level_id; ?>"
                data-menu="<?= $sub_menu_id ?>" 
                data-operation="<?php echo $splitaccessandstatus[0]; ?>"
                data-level="<?= $namamenu ?>",
                data-submenu="<?= $namasubmenu ?>">
              <?php
            } else {
            ?>
            <input class="form-check-input-access" type="checkbox"
                style="height: 2em;
                width: 2em;"
                data-role="<?= $level_id; ?>"
                data-menu="<?= $sub_menu_id ?>" 
                data-operation="<?php echo $splitaccessandstatus[0]; ?>"
                data-level="<?= $namamenu ?>",
                data-submenu="<?= $namasubmenu ?>"
                checked="checked">
            <?php } ?>
      		</td>
      		<td>
	          	<label class="" for="customCheck1"><?php echo $splitaccessandstatus[0]; ?> <span><button type="button" class="btn btn-default" data-toggle="tooltip" style="border: none;
	    padding: 3px;
	    color: #73879c;
	    margin-top: 2px;" data-placement="top" title="" data-original-title="<?php echo $splitaccessandstatus[1] ?>"><i class="fa fa-question-circle"></i></button></span></label><br>
        	</td>
        	<td style="width: 18%;">
        		
            <button class="btn btn-danger btn-sm" id="btndeleteAccess" 
            data-level="<?php echo $level_id ?>"
            data-menu="<?php echo $sub_menu_id; ?>"
            data-controller="<?php echo $this->uri->segment(1) ?>"
            data-method="delete_custom_access"><i class="fa fa-trash" aria-hidden="true"></i></button>
        		
        	</td>
      	</tr>
  	<?php 
  			}
  		}?>	
      
      
      <tr>
        <td colspan="3">Ada hak akses tambahan? <span><button class ="btn btn-success btn-xs" data-toggle="modal" data-target="#modalTambahAksesuntuk<?php echo $level_id.$sub_menu_id.$namasubmenu; ?>">tambah hak akses</button></span></td>
      </tr>
    </tbody>
  </table>
  <div class="modal fade" id="modalTambahAksesuntuk<?php echo $level_id.$sub_menu_id.$namasubmenu; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel2">Tambah Akses</h4>
        </div>
        <div class="modal-body">
          	<p>Pastikan nama akses yang diberi tersedia pada sub menu. Akses ini akan diterapkan pada <?php echo $namalevel ?></p>
			<div class="input-group">
	           <input type="text" class="form-control tb-custom-access-name"
              data-submenuid="<?php echo $sub_menu_id ?>"
              data-role="<?php echo $level_id ?>"
              name="access_name" placeholder="Masukan nama akses" style="text-transform: lowercase;" value='' onpaste="return false">
	            <span class="input-group-btn">
	                <button type="button" class="btn btn-warning" style="pointer-events: none;"><i class="fa fa-warning"></i></button>
				</span>
	        </div>
          <div id="warning-name-access"></div>
	        <div style="margin: 12px 0;">
	        	<textarea class="form-control tb-custom-access-description" name="access_description" rows="3" placeholder="Deskripsi akses"></textarea>
	        </div>
	        <div style="display: grid; grid-template-columns: 0.2fr 1fr;">
	        	<input class="form-check-input" type="checkbox" id="allowaccesscheck" name="allowaccesscheck" style="height: 27px;
    width: 27px;">
                <p style="word-break: break-word;" for="">Izinkan <?php echo $namalevel ?> untuk melakukan akses tersebut? (jangan lakukan ceklis pada kotak disamping untuk membatasi <?php echo $namalevel ?> melakukan tindakan yang anda tentukan diatas)</p>
	        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <input type="hidden" name="nama_sub_menu" id="nama_sub_menu" value="<?php echo $namasubmenu ?>">
          <input type="hidden" name="nama_menu" id="nama_menu" value="<?php echo $namamenu ?>">

          <button type="submit" class="btn btn-primary btnsaveAccess" id="btnsaveAccess" onclick="saveCustomAccess(this,<?php echo $level_id ?>,<?php echo $sub_menu_id; ?>,'<?php echo $this->uri->segment(1) ?>','add_custom_access');">Simpan</button>
        </div>

      </div>
    </div>
  </div>


    <?php
  } else {
    ?>
    <p><span><i class='fa fa-warning fa-fw fa-md'></i> Aktifkan menu untuk mengatur hak akses</span></p>
    <?php
  }?>