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
					<div class="info-pembayaran-wrapper">
			        <?php

				        $arr = array(
				        	'invoice_id' => $invoice_id,
				        	'total_price_sale' => $total_price_sale,
				            'biaya_admin' => $biaya_admin,
				            'total_bayar' => $total_bayar,
				            'dibayar' => $dibayar,
				            'status_sale' => $status_sale,
				            'last_updated' => $last_updated,
				            'list_cicilan' => $list_cicilan,

				            'sisapembayaranbrapax' => $sisapembayaranbrapax,

				            'progresscicilan' => $progresscicilan
				        );
			        	$this->load->view('cicilan/info_pembayaran', $arr)
			        ?>
					</div>
			    </div>
			</div>
		</div>





<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
    	<div class="loading-table-indicator-wrapper" style="position: absolute;
		display: none;
		background: #0000003d;
		width: 100%;
		height: 100%;
		z-index: 999;">
    		<i class="fa fa-refresh fa-spin" style="margin: auto; font-size: 51px;color: white;"></i>
    	</div>
        <h2 style="margin-top:0px">Kelola Data Cicilan <span><button class="btn btn-default btn-xs" id="btn-reload" data-invoice="<?php echo $invoice ?>"><i class="fa fa-refresh"></i></button></span></h2>
        <input type="hidden" name="id_sale" class="id_sale" value="<?php echo $invoice ?>">
        <div class="tabel-pembayaran-cicilan" style="position: relative;">  	
	    	<?php
	    		$e = array(
	    			'list_cicilan' => $list_cicilan,
	    			'sisapembayaranbrapax' => $sisapembayaranbrapax,
	    			'classnyak' => $classnyak
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