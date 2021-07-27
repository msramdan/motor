<div class="col-md-6">
	<div class="x_panel">
        <h2 style="margin-top:0px">Overview</h2>
        <table class="table">
		    <tr><td>Invoice</td><td><?php echo $invoice; ?></td></tr>
		    <tr><td>Pelanggan</td><td><?php echo $pelanggan_id; ?></td></tr>
		    <tr><td>Item</td><td><?php echo $item_id; ?></td></tr>
		    <tr><td>Total Price Sale</td><td><?php echo $total_price_sale; ?></td></tr>
		    <tr><td>Biaya Admin</td><td><?php echo $biaya_admin; ?></td></tr>
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
        <label class="label label-warning">Sedang dalam Cicilan</label>
        <table>
        	<tr><td>Total pembayaran</td><td>: </td></tr>
        </table>
    </div>
</div>