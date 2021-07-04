<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
    <body>
        <h2 style="margin-top:0px">Sale Read</h2>
        <table class="table">
	    <tr><td>Invoice</td><td><?php echo $invoice; ?></td></tr>
	    <tr><td>Pelanggan</td><td><?php echo $pelanggan_id; ?></td></tr>
	    <tr><td>Item</td><td><?php echo $kendaraan_id; ?></td></tr>
	    <tr><td>Total Price Sale</td><td><?php echo $total_price_sale; ?></td></tr>
	    <tr><td>Biaya Admin</td><td><?php echo $biaya_admin; ?></td></tr>
	    <tr><td>Type Sale</td><td><?php echo $type_sale; ?></td></tr>
	    <tr><td>Tanggal Sale</td><td><?php echo $tanggal_sale; ?></td></tr>
	    <tr><td>Penginput</td><td><?php echo $user_id; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('sale') ?>" class="btn btn-default">Cancel</a><a href="" class="btn btn-warning">Cetak</a></td></tr>
	</table>
        </body>
    </div>
</div>