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
		    <tr><td></td><td><a href="<?php echo site_url('sale') ?>" class="btn btn-default">Cancel</a><a href="<?php echo base_url() ?>sale/cetak_faktur/<?php echo $sale_id ?>" class="btn btn-warning">Cetak</a></td></tr>
		</table>
    </div>
</div>

<div class="col-md-6">
	<div class="x_panel">
        <h2 style="margin-top:0px">Info Pembayaran</h2>
        <?php
        if (intval($dibayar) < intval($total_bayar)) {
        	?>
        	<label class="label label-warning" style="font-size: 1em;">Sedang dalam Cicilan</label>
        	<a class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
        	<?php
        } else {
        	?>
        	<label class="label label-success" style="font-size: 1em;">Lunas</label>
        	<?php
        }
		?>

        <table class="table" style="margin-top: 10px;">
        	<tr><td>Harga Beli Item</td><td>: </td><td><?php echo $total_price_sale; ?></td></tr>
        	<tr><td>Biaya Admin</td><td>: </td><td><?php echo $biaya_admin; ?></td></tr>
        	<tr><td>Total</td><td>: </td><td><?php echo $total_bayar; ?></td></tr>
        	<tr><td>Dibayar</td><td>: </td><td><?php echo $dibayar; ?></td></tr>
        	<tr><td>Sisa</td><td>: </td><td><?php echo intval($total_bayar) - intval($dibayar); ?></td></tr>
        	<tr><td>Pembayaran Terakhir</td><td>: </td><td><?php echo $last_updated; ?></td></tr>
        </table>
    </div>
</div>