<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
    <body>
        <h2 style="margin-top:0px">Approval_lists Read</h2>
        <table class="table">
	    <tr><td>Invoice Id</td><td><?php echo $invoice_id; ?></td></tr>
	    <tr><td>Approve By</td><td><ul>
				    	<?php
					    $appa = json_decode($approve_by, true);
					    
						foreach ($appa as $k => $v) {
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
			    	</ul></td></tr>
	    <tr><td>Approval Status</td><td><?php echo $approval_status; ?></td></tr>
	    <tr><td>Keterangan</td><td><ul>
				    	<?php
					    $appb = json_decode($keterangan, true);
					    
						foreach ($appb as $k => $v) {
							echo '<li>'.$k.': '.$v.'</li>';
						}
					    ?>
			    	</ul></td></tr>
	    <tr><td></td><td>
	    	<a href="<?php echo site_url('approval_lists') ?>" class="btn btn-default">Cancel</a>
	    	<form action="yes" method="post">
				<input type="hidden" name="invoicehidden" id="invoicehidden" value="<?php echo $invoice_id ?>">
				<input type="hidden" name="approval_id" id="approval_id" value="<?php echo $approval_id ?>">
				<input type="hidden" name="nominal_diskon" id="nominal_diskon" value="<?php echo $appb['jumlahpotonganyangdiajukan'] ?>">
				<input type="hidden" name="jumlah_denda" id="jumlah_denda" value="<?php echo $appb['jumlahdendasaatini'] ?>">
				<div class="btn-group">
					<button type="submit" class="btn btn-primary">Setujui</button>
				</div>
			</form>

			<form action="no" method="post">
				<input type="hidden" name="invoicehidden" id="invoicehidden" value="<?php echo $invoice_id ?>">
				<input type="hidden" name="approval_id" id="approval_id" value="<?php echo $approval_id ?>">
				<textarea placeholder="alasan tolak" name="komentar" id="komentar" rows="3" style="resize: none; margin: 1vh 0;"></textarea>
				<div class="btn-group">
					<button type="submit" disabled class="btn btn-danger btn-init-tolak">Tolak</button>
				</div>
			</form></td></tr>
	</table>
        </body>
    </div>
</div>

<script type="text/javascript">
	
	$('#komentar').on('input',function() {
		if (!$(this).val()) {
			$('.btn-init-tolak').attr("disabled", true);
		} else {
			$('.btn-init-tolak').removeAttr("disabled");
		}
	});
</script>