<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
    <body>
        <h2 style="margin-top:0px">Approval_lists Read</h2>
        <table class="table">
	    <tr><td>Invoice Id</td><td><?php echo $invoice_id; ?></td></tr>
	    <tr><td>Approve By</td><td><?php echo $approve_by; ?></td></tr>
	    <tr><td>Approval Status</td><td><?php echo $approval_status; ?></td></tr>
	    <tr><td>Keterangan</td><td><?php echo $keterangan; ?></td></tr>
	    <tr><td>Komentar</td><td><?php echo $komentar; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('approval_lists') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
    </div>
</div>