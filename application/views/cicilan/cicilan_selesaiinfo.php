<div style="margin-top: 2vh;">
	<div class="alert alert-success alert-dismissible">
    	<p><b>Catatan:</b> Cicilan untuk <?php echo $invoice_id ?> Telah menyelesaikan cicilan</p>
    </div>
	<div style="display: flex;justify-content: center;text-align: center;">
		<?php 
			$wh = json_decode($whoisreviewing, true);
			foreach ($wh as $key => $value) {
				if ($value == '-') {
					?>
					<div style="width: 25%;">
						<div style="position: relative;">
							<i class="fa fa-users" style="font-size: 67px;"></i>
							<i class="fa fa-minus" style="font-size: 27px; position: absolute; bottom: 0;"></i>
						</div>
						<h3><?php echo $key ?></h3>

						<p><label class="label label-default">Dalam Review</label></p>
					</div>
					<?php
				}

				if ($value == 'true') {
					?>
					<div style="width: 25%;">
						<div style="position: relative;">
							<i class="fa fa-users" style="font-size: 67px;"></i>
							<i class="fa fa-check-circle" style="font-size: 27px; color: green; position: absolute; bottom: 0;"></i>
						</div>
						<h3><?php echo $key ?></h3>

						<p><label class="label label-success">Disetujui</label></p>
					</div>
					<?php
				}

				if ($value == 'false') {
					?>
					<div style="width: 25%;">
						<div style="position: relative;">
							<i class="fa fa-users" style="font-size: 67px;"></i>
							<i class="fa fa-times-circle" style="font-size: 27px; color: red; position: absolute; bottom: 0;"></i>
						</div>
						<h3><?php echo $key ?></h3>

						<p><label class="label label-danger">Ditolak</label></p>
					</div>
					<?php
				}
			}
		?>
	</div>
	<div style="width: 100%; text-align: center; margin: 25px 0;">
		<button class="btn btn-default btn-lg" id="btn-show-detail">Detail</button>
	</div>

	<div class="loading-wrapper" style="display: none; text-align: center;">
		<i class="fa fa-circle-o-notch fa-spin" style="font-size: 42px;"></i>
	</div>

	<div class="detailinvoice-wrapper" style="display: none;">
		<div class="row">
			<div class="col-md-6">
				<div class="x_panel">
			        <h2 style="margin-top:0px">Overview</h2>
			        <table class="table">
					    <tr><td>Invoice</td><td><?php echo $invoice_id; ?></td></tr>
					    <tr><td>Pelanggan</td><td><?php echo $pelanggan_id; ?></td></tr>
					    <tr><td>Item</td><td><?php echo $item_id; ?></td></tr>
					    <tr><td>Type Sale</td><td><?php echo $type_sale; ?></td></tr>
					    <tr><td>Tanggal Sale</td><td><?php echo $tanggal_sale; ?></td></tr>
					    <tr><td>Penginput</td><td><?php echo $user_id; ?></td></tr>
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
			        <?php
			        if($status_sale === 'Selesai')
			        {?>
			            <label class="label label-success" style="font-size: 1em;">Lunas</label>
			            <table class="table" style="margin-top: 10px;">
				        	<tr><td>Harga Beli Item</td><td>: </td><td><?php echo $total_price_sale; ?></td></tr>
				        	<tr><td>Biaya Admin</td><td>: </td><td><?php echo $biaya_admin; ?></td></tr>
				        	<tr><td>Total</td><td>: </td><td><?php echo $total_bayar; ?></td></tr>
				        	<tr><td>Dibayar</td><td>: </td><td><?php echo $dibayar; ?></td></tr>
				        	<tr><td>Sisa</td><td>: </td><td><?php echo intval($total_bayar) - intval($dibayar); ?></td></tr>
				        	<tr><td>Pembayaran Terakhir</td><td>: </td><td><?php echo $last_updated; ?></td></tr>
				        </table>
			        <?php }
			        if ($status_sale === 'Belum Dibayar') {
			            ?>
			            <label class="label label-danger" style="font-size: 1em;">Belum Terjadi Transaksi</label>
			            <table class="table" style="margin-top: 10px;">
				        	<tr><td>Harga Beli Item</td><td>: </td><td><?php echo $total_price_sale; ?></td></tr>
				        	<tr><td>Biaya Admin</td><td>: </td><td><?php echo $biaya_admin; ?></td></tr>
				        	<tr><td>Total</td><td>: </td><td><?php echo $total_bayar; ?></td></tr>
				        	<tr><td>Dibayar</td><td>: </td><td><?php echo $dibayar; ?></td></tr>
				        	<tr><td>Sisa</td><td>: </td><td><?php echo intval($total_bayar) - intval($dibayar); ?></td></tr>
				        </table>
			        <?
			        }
			        if ($status_sale === 'Dalam Cicilan') {
			            ?>
			            <label class="label label-warning" style="font-size: 1em;">Sedang dalam Cicilan</label>
			        	<table class="table" style="margin-top: 10px;">
				        	<tr><td>Harga Beli Item</td><td>: </td><td><?php echo $total_price_sale; ?></td></tr>
				        	<tr><td>Biaya Admin</td><td>: </td><td><?php echo $biaya_admin; ?></td></tr>
				        	<tr><td>Total</td><td>: </td><td><?php echo $total_bayar; ?></td></tr>
				        	<tr><td>Dibayar</td><td>: </td><td><?php echo $dibayar; ?></td></tr>
				        	<tr><td>Sisa</td><td>: </td><td><?php echo intval($total_bayar) - intval($dibayar); ?></td></tr>
				        	<tr><td>Pembayaran Terakhir</td><td>: </td><td><?php echo $last_updated; ?></td></tr>
				        </table>
			        <?
			        }
			        if ($status_sale === 'Dalam Review') {
			            ?>
			            <label class="label label-primary" style="font-size: 1em;">Sedang dalam Review</label>
			        	<a class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
			        	<table class="table" style="margin-top: 10px;">
				        	<tr><td>Harga Beli Item</td><td>: </td><td><?php echo $total_price_sale; ?></td></tr>
				        	<tr><td>Biaya Admin</td><td>: </td><td><?php echo $biaya_admin; ?></td></tr>
				        	<tr><td>Total</td><td>: </td><td><?php echo $total_bayar; ?></td></tr>
				        	<tr><td>Dibayar</td><td>: </td><td><?php echo $dibayar; ?></td></tr>
				        	<tr><td>Sisa</td><td>: </td><td><?php echo intval($total_bayar) - intval($dibayar); ?></td></tr>
				        	<tr><td>Pembayaran Terakhir</td><td>: </td><td><?php echo $last_updated; ?></td></tr>
				        </table>
			        <?
			        }
			        if ($status_sale === 'Ditolak') {
			            ?>
			            <label class="label label-danger" style="font-size: 1em;">Tidak Disetujui</label>
			        	<table class="table" style="margin-top: 10px;">
				        	<tr><td>Harga Beli Item</td><td>: </td><td><?php echo $total_price_sale; ?></td></tr>
				        	<tr><td>Biaya Admin</td><td>: </td><td><?php echo $biaya_admin; ?></td></tr>
				        	<tr><td>Total</td><td>: </td><td><?php echo $total_bayar; ?></td></tr>
				        	<tr><td>Dibayar</td><td>: </td><td><?php echo $dibayar; ?></td></tr>
				        	<tr><td>Sisa</td><td>: </td><td><?php echo intval($total_bayar) - intval($dibayar); ?></td></tr>
				        	<tr><td>Pembayaran Terakhir</td><td>: </td><td><?php echo $last_updated; ?></td></tr>
				        </table>
			        <?
			        }?>

			        <?php
			        if ($status_sale === 'Ditolak') {
			        	?>
			        	<div class="alert alert-danger alert-dismissible">
					    	<p><b>Alasan Tolak :</b> <?php echo $komentar ?></p>
					    </div>
			        	<?php
			        }
			        ?>
			    </div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).on('click','#btn-show-detail', function() {
		
		$('.loading-wrapper').css('display','block')

		setTimeout(function() {
			$('.loading-wrapper').css('display','none')
			$('.detailinvoice-wrapper').css('display','unset')			
		}, 3000)

		$(this).attr('id','btn-hide-detail');
	})

	$(document).on('click','#btn-hide-detail', function() {
		$('.detailinvoice-wrapper').css('display','none')
		$(this).attr('id','btn-show-detail');
	})

</script>