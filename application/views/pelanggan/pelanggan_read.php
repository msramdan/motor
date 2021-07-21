<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
    <body>
        <h2 style="margin-top:0px">Pelanggan Read</h2>
        <table class="table">
	    <tr><td>No Ktp</td><td><?php echo $no_ktp; ?></td></tr>
	    <tr><td>No Kk</td><td><?php echo $no_kk; ?></td></tr>
	    <tr><td>Nama Pelanggan</td><td><?php echo $nama_pelanggan; ?></td></tr>
	    <tr><td>No Hp Pelanggan</td><td><?php echo $no_hp_pelanggan; ?></td></tr>
	    <tr><td>Jenis Kelamin</td><td><?php echo $jenis_kelamin; ?></td></tr>
	    <tr><td>Alamat Ktp</td><td><?php echo $alamat_ktp; ?></td></tr>
	    <tr><td>Alamat Domisili</td><td><?php echo $alamat_domisili; ?></td></tr>
	    <tr><td>Nama Saudara</td><td><?php echo $nama_saudara; ?></td></tr>
	    <tr><td>Alamat Saudara</td><td><?php echo $alamat_saudara; ?></td></tr>
	    <tr><td>No Hp Saudara</td><td><?php echo $no_hp_saudara; ?></td></tr>
	    <tr>
	    	<td>Berkas Pelanggan</td>
	    	<td>
	    		<table class="table table-sm table-bordered">	    		
	    			
	    				<tr>
		                  <th>Nama Berkas</th>
		                  <th>Download</th>
		                  <th>Hapus</th>
		                </tr>
		                <?php foreach ($berkas->result() as $key => $data) { ?>
		    			<tr>
		    				<td> <?php echo $data->nama_berkas ?></td>
		    				<td><a href="<?php echo base_url(); ?>pelanggan/download_berkas/<?php echo $data->photo ?>"><i class="ace-icon fa fa-download"></i> Download</a></td>
		    				<td><a href="<?=site_url('pelanggan/del_berkas/'.$data->berkas_id.'/' .$this->uri->segment(3))?>" onclick="return confirm('Yakin Akan Hapus ?')" class ="btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></a></td>
		    			</tr>
	    			<?php } ?>
	    		</table>  		
	    		
	    	
	    	</td>
	    </tr>
	    <tr><td></td><td><a href="<?php echo site_url('pelanggan') ?>" class="btn btn-default">Cancel</a><a href="<?php echo site_url('pelanggan/cetak').'/'.$this->uri->segment(3) ?>" class="btn btn-warning">Cetak</a></td></tr>
	</table>
        </body>
    </div>
</div>