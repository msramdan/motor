<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
    <body>
        <h2 style="margin-top:0px">Kendaraan Read</h2>
        <table class="table">
	    <tr><td>Kd Pembelian</td><td><?php echo $kd_pembelian; ?></td></tr>
	    <tr><td>Agen Id</td><td><?php echo $agen_id; ?></td></tr>
	    <tr><td>Kd Kendaraan</td><td><?php echo $kd_kendaraan; ?></td></tr>
	    <tr><td>Nama Kendaraan</td><td><?php echo $nama_kendaraan; ?></td></tr>
	    <tr><td>Jenis Kendaraan Id</td><td><?php echo $jenis_kendaraan_id; ?></td></tr>
	    <tr><td>Merek Id</td><td><?php echo $merek_id; ?></td></tr>
	    <tr><td>No Stnk</td><td><?php echo $no_stnk; ?></td></tr>
	    <tr><td>No Bpkb</td><td><?php echo $no_bpkb; ?></td></tr>
	    <tr><td>Deskripsi</td><td><?php echo $deskripsi; ?></td></tr>
	    <tr><td>Harga Beli</td><td><?php echo $harga_beli; ?></td></tr>
	    <tr><td>Photo</td><td><?php echo $photo; ?></td></tr>
	    <tr><td>Status</td><td><?php echo $status; ?></td></tr>

	    <tr>
	    	<td>Detail Biaya</td>
	    	<td>
	    		<table class="table table-sm table-bordered">	    		
	    			
	    				<tr>
		                  <th>Nama Biaya</th>
		                  <th>Nominal</th>
		                  <th>Hapus</th>
		                </tr>
		                <?php foreach ($harga->result() as $key => $data) { ?>
		    			<tr>
		    				<td> <?php echo $data->nama_harga ?></td>
		    				<td> <?php echo $data->nominal ?></td>
		    				<td><a href="<?=site_url('kendaraan/del_harga/'.$data->harga_id.'/' .$this->uri->segment(3))?>" onclick="return confirm('Yakin Akan Hapus ?')" class ="btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></a></td>
		    			</tr>
	    			<?php } ?>
	    		</table>  		
	    		
	    	
	    	</td>
	    </tr>

	    <tr><td></td><td><a href="<?php echo site_url('kendaraan') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
    </div>
</div>