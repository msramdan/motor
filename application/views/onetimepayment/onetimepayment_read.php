<a href="<?php echo base_url() ?>sale/cetak_faktur/<?php echo $sale_id ?>" class="btn btn-warning">Cetak Faktur</a>
<div class="row">

	<div class="col-md-6">
		<div class="x_panel">
	        <h2 style="margin-top:0px">Overview</h2>
	        <table class="table">
			    <tr><td>Invoice</td><td><?php echo $invoice; ?></td></tr>
			    <tr><td>Pelanggan</td><td><?php echo $pelanggan_id; ?></td></tr>
			    <tr><td>Item</td><td><?php echo $item_id; ?></td></tr>
			    <tr><td>Type Sale</td><td><?php echo $type_sale; ?></td></tr>
			    <tr><td>Tanggal Sale</td><td><?php echo $tanggal_sale; ?></td></tr>
			    <tr><td>Penginput</td><td><?php echo $user_id; ?></td></tr>
			</table>
	    </div>
	</div>
	<div class="col-md-6">
		<div class="x_panel">
	        <?php
	        if($status_sale === 'Selesai')
	        {?>
	        	<h2 style="margin-top:0px">Info Pembayaran <span><label class="label label-success" style="font-size: 0.8em;">Lunas</label></span></h2>
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
	            <h2 style="margin-top:0px">Info Pembayaran <span><label class="label label-danger" style="font-size: 0.8em;">Belum Terjadi Transaksi</label></span></h2>
	            <table class="table" style="margin-top: 10px;">
		        	<tr><td>Harga Beli Item</td><td>: </td><td><?php echo $total_price_sale; ?></td></tr>
		        	<tr><td>Biaya Admin</td><td>: </td><td><?php echo $biaya_admin; ?></td></tr>
		        	<tr><td>Total</td><td>: </td><td><?php echo $total_bayar; ?></td></tr>
		        	<tr><td>Dibayar</td><td>: </td><td><?php echo $dibayar; ?></td></tr>
		        	<tr><td>Sisa</td><td>: </td><td><?php echo intval($total_bayar) - intval($dibayar); ?></td></tr>
		        </table>
		    <?php } ?>
	    </div>
	</div>
</div>