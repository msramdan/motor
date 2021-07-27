<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
    <body>
        <h2 style="margin-top:0px">Sale_detail Read</h2>
        <table class="table">
	    <tr><td>Sale Id</td><td><?php echo $sale_id; ?></td></tr>
	    <tr><td>Pembayaran Ke</td><td><?php echo $pembayaran_ke; ?></td></tr>
	    <tr><td>Status</td><td><?php echo $status; ?></td></tr>
	    <tr><td>Total Bayar</td><td><?php echo $total_bayar; ?></td></tr>
	    <tr><td>Jatuh Tempo</td><td><?php echo $jatuh_tempo; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('cicilan') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
    </div>
</div>