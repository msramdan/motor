<div class="row">
	<div class="col-md-6">
		<div class="x_panel">
	        <h2 style="margin-top:0px">Overview</h2>
	        <table class="table">
			    <tr><td>Invoice</td><td><?php echo $invoice; ?></td><td></td></tr>
			    <tr><td><b>Pelanggan</b></td><td><?php echo $nama_pelanggan; ?></td><td><span><a class="btn btn-primary btn-xs" href="<?php echo base_url().'pelanggan/read/'.$pelanggan_id ?>" target="_blank" and rel="noopener noreferrer"><i class="fa fa-eye"></i></a></span></td></tr>
			    <tr><td><b>Alamat</b></td><td><?php echo $alamat_domisili; ?></td><td></td></tr>
			    <tr><td>Jenis Barang</td><td><?php echo $nama_jenis_item; ?></td><td></td></tr>
			    <tr><td>Merk</td><td><?php echo $nama_merek; ?></td><td></td></tr>
			    <tr><td>Type</td><td><?php echo $nama_type; ?></td><td></td></tr>
			    <tr><td>No. BPKB</td><td><?php echo $no_bpkb; ?></td><td><span><a class="btn btn-primary btn-xs" href="<?php echo base_url().'item/read/'.$item_id ?>" target="_blank" and rel="noopener noreferrer"><i class="fa fa-eye"></i></a></span></td></tr>
			    <tr><td>Warna</td><td><?php echo $warna1.'/'.$warna2; ?></td><td></td></tr>
			    <tr><td>Status Approval</td><td>
			    	<ul>
				    	<?php
					    $app = json_decode($approval, true);
					    
						foreach ($app as $k => $v) {
							if ($v == 'true') {
								echo '<li>'.$k.': <label class="label label-success">'.$v.'</label></li>';
							}
							if ($v == 'false') {
								echo '<li>'.$k.': <label class="label label-danger">'.$v.'</label></li>';
							}
							if ($v == '-') {
								echo '<li>'.$k.': -</li>';
							}
						}
					    ?>
			    	</ul>
			    	</td>
			    </tr>
			    <tr>
			    	<td>Berkas Pelanggan</td>
			    	<td>
			    		<table class="table table-sm table-bordered">	    		
			    			
			    				<tr>
				                  <th>Nama Berkas</th>
				                  <th>Download</th>
				                </tr>
				                <?php foreach ($berkas->result() as $key => $data) { ?>
				    			<tr>
				    				<td> <?php echo $data->nama_berkas ?></td>
				    				<td><a href="<?php echo base_url(); ?>pelanggan/download_berkas/<?php echo $data->photo ?>"><i class="ace-icon fa fa-download"></i> Download</a></td>
				    			</tr>
			    			<?php } ?>
			    		</table>  		
			    		
			    	
			    	</td>
			    </tr>
			</table>
	    </div>
	</div>

	<div class="col-md-6">
		<div class="x_panel">
			<h2 style="margin-top:0px">Info Pembayaran</h2>
			<table class="table" style="margin-top: 10px;">
	        	<tr><td>Harga Nominal</td><td>: </td><td><?php echo $total_price_sale; ?></td></tr>
	        	<tr><td>Pokok Kredit</td><td>: </td><td><?php echo $bunga_cicilan->pokok_cicilan.' + '.$bunga_cicilan->nilai_bunga_percicilan.'%'; ?></td></tr>
	        	<tr><td>Angsuran/bulan</td><td>: </td><td><?php echo $bunga_cicilan->harus_dibayar ?></td></tr>
	        	<tr><td>Jangka Waktu</td><td>: </td><td><?php echo $bunga_cicilan->brapaxcicilan.' Bulan'; ?></td></tr>
	        	<tr><td>Tanggal Pembayaran</td><td>: </td><td><?php echo 'Setiap tanggal '. $bunga_cicilan->tiap_tanggal; ?></td></tr>
	        </table>
	    </div>
	</div>
</div>

<div>
	<h2>Prediksi Pembayaran</h2>
	<table class="table table-striped table-bordered">
		<tr>
			<th rowspan="2" style="vertical-align: inherit; width: 20px;">No</th>
			<th rowspan="2" style="vertical-align: inherit;">Jatuh Tempo</th>
			<th colspan="3">Angsuran</th>
			<th colspan="2">Saldo Piutang</th>
			<th rowspan="2" style="vertical-align: inherit;">Keterangan</th>
		</tr>
		<tr>
			<th>Nominal</th>
			<th>Pokok</th>
			<th>Bunga</th>
			<th>Pokok</th>
			<th>Bruto</th>
		</tr>
		<?php


			$pokok =  $data_cicilan[0]->pokok_cicilan * sizeof($data_cicilan);
			$bruto =  $data_cicilan[0]->harus_dibayar * sizeof($data_cicilan);

			$no = 1;
			foreach ($data_cicilan as $v) {
				
				?>
				<tr>
					<td><?php echo $no++ ?></td>
					<td><?php echo date("d/m/Y", strtotime($v->jatuh_tempo)) ?></td>
					<td><?php echo $v->harus_dibayar ?></td>
					<td><?php echo $v->pokok_cicilan ?></td>
					<td><?php echo $v->harus_dibayar - $v->pokok_cicilan; ?></td>
					<td><?php echo $pokok -= $v->pokok_cicilan ?></td>
					<td><?php echo $bruto -= $v->harus_dibayar ?></td>
					<td>Bayar</td>
				</tr>
				<?php
			}
		?>
	</table>

	<div class="alert alert-danger alert-dismissible">
    	<p><b>Catatan:</b> <?php echo $catatan ?></p>
    </div>
</div>


<a href="<?php echo base_url() ?>Approval_lists" class="btn btn-secondary">Kembali</a>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Pilih Tindakan</button>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
	  <div class="modal-content">

	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
	      </button>
	      <h4 class="modal-title" id="myModalLabel2">Pilih Tindakan</h4>
	    </div>
	    <div class="modal-body">
	    <center>
			<div class="btn-group button-action-choice" style="margin: auto;">
				<button class="btn btn-primary btn-setuju btn-lg" style="width: 90px;"><i class="fa fa-check"></i><p>Setuju</p></button>
		        <button class="btn btn-danger btn-tolak btn-lg" style="width: 90px;"><i class="fa fa-times"></i><p>Tolak</p></button>
				<button class="btn btn-secondary btn-lg" data-dismiss="modal" style="width: 90px;"><i class="fa fa-sign-out"></i><p>Batal</p></button>
	      	</div>

	      	<div class="group-setuju btn-group-confirmation-action" style="display: none;">
	      		<?php
	      		if ($result == 'no') {
					?>
					<form action="yes" method="post">
						<input type="hidden" name="invoicehidden" id="invoicehidden" value="<?php echo $invoice ?>">
						<div class="btn-group">
							<button type="submit" class="btn btn-secondary btn-lg" style="width: 90px;"><i class="fa fa-sign-out"></i><p>Ya</p></button>
							<button class="btn btn-danger btn-lg btn-cancel-confirmation" style="width: 90px;"><i class="fa fa-times"></i><p>Batal</p></button>
						</div>
					</form>
					<?php
					} else {
						?>
						<h4>Tidak dapat melakukan tindakan tersebut</h4>
						<?php
					}
				?>
	      	</div>

	      	<div class="group-tolak btn-group-confirmation-action" style="display: none;">
	      		<?php if ($result == 'no') {
	      			?>
	      			<form action="no" method="post">
						<input type="hidden" name="invoicehidden" id="invoicehidden" value="<?php echo $invoice ?>">
						<textarea placeholder="alasan tolak" name="komentar" id="komentar" rows="3" style="resize: none; margin: 1vh 0;"></textarea>
						<div class="btn-group">
							<button type="submit" disabled class="btn btn-secondary btn-lg btn-init-tolak" style="width: 90px;"><i class="fa fa-sign-out"></i><p>Ya</p></button>
							<button class="btn btn-danger btn-lg btn-cancel-confirmation" style="width: 90px;"><i class="fa fa-times"></i><p>Batal</p></button>
						</div>
					</form>
	      			<?php
					} else {
						?>
						<h4>Tidak dapat melakukan tindakan tersebut</h4>
	      			<?php
	      		} ?>
	      	</div>
      	</center>
		
	    </div>
	  </div>
</div>
</div>

<script type="text/javascript">
	$('.btn-setuju').click(function() {
		$('.button-action-choice').css('display','none')
		$('.group-setuju').css('display','inline-block')
		$('#myModalLabel2').text('Anda yakin? (Setujui Approval)')
	})

	$('.btn-tolak').click(function() {
		$('.button-action-choice').css('display','none')
		$('.group-tolak').css('display','inline-block')
		$('#myModalLabel2').text('Anda yakin? (Tolak Approval)')
	})

	$('.btn-cancel-confirmation').click(function(e) {
		e.preventDefault()
		$('#myModalLabel2').text('Pilih Tindakan')
		$('.btn-group-confirmation-action').css('display','none')
		$('.button-action-choice').css('display','inline-block')
	})

	$('#komentar').on('input',function() {
		if (!$(this).val()) {
			$('.btn-init-tolak').attr("disabled", true);
		} else {
			$('.btn-init-tolak').removeAttr("disabled");
		}
	});


</script>