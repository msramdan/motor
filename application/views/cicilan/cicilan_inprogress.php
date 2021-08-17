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
					    <tr><td></td><td></td></tr>
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
			        <?php
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
			        <?php
			        }
			        ?>
			        <div class="project_progress">
                       <div class="progress">
                          <div class="progress-bar <?php echo $progresscicilan->total_dibayar == $progresscicilan->total_angsuran ? 'progress-bar-success progress-bar-striped' : 'progress-bar-warning progress-bar-striped'; ?> active" role="progressbar"
                          aria-valuenow="<?php echo $progresscicilan->total_dibayar; ?>" aria-valuemin="0" aria-valuemax="<?php echo $progresscicilan->total_angsuran; ?>" style="width:<?php echo intval($progresscicilan->total_dibayar)/ intval($progresscicilan->total_angsuran) * 100; ?>%">
                            <?php echo round(intval($progresscicilan->total_dibayar)/ intval($progresscicilan->total_angsuran) * 100, 2); ?>%
                          </div>
                        </div>
                        <small><?php echo $progresscicilan->total_dibayar; ?>/<?php echo $progresscicilan->total_angsuran; ?> Terbayar</small>
                    </div>
                    <div>
                    	<a class="btn btn-primary" href="<?php echo base_url().'r_cicilan/cetak_kartupiutang/'.$invoice_id ?>">Kartu Piutang</a>
                    </div>
			    </div>
			</div>
		</div>





<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <h2 style="margin-top:0px">Kelola Data Cicilan</h2>
        <input type="hidden" name="id_sale" class="id_sale" value="<?php echo $invoice ?>">
        <div class="tabel-pembayaran-cicilan">  	
	    	<?php
	    		$e = array(
	    			'list_cicilan' => $list_cicilan,
	    			'sisapembayaranbrapax' => $sisapembayaranbrapax
	    		);
	    		$this->load->view('cicilan/cicilan_table', $e);
	    	?>
        </div>
		<span class="wrapper-confirmation-lunas-action">
			
		</span>
    </div>
</div>

<script type="text/javascript">

	window.onbeforeunload = function(e) {
	  	var all = document.querySelectorAll('.bton-action > span > .btn').length
		var lunas = document.querySelectorAll('.bton-action > span > .btn-success').length

		if(lunas == all) {
		    //console.log('beluumm')
		    return 'BElum smua? yakin?'
		}
	};
</script>