<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
    <body>
        <h2 style="margin-top:0px">Sale_detail Read</h2>
        <table class="table">
        	<tr>
        		<th>Pembayaran ke</th>
        		<th>Status</th>
        	</tr>
	    	<?php
	    	foreach($list_cicilan as $lc) {
	    		?>
	    			<tr>
	    				<td><?php echo $lc->pembayaran_ke ?></td>
	    				<td>
	    					<?php
	    						if ($lc->total_bayar === 0) {
	    							?>
	    								<button type="button" class="btn btn-warning btn-xs">Success</button>
	    							<?php
	    							return
	    						}


	    						?>
	    							<button type="button" class="btn btn-warning btn-xs">Belum Lunas</button>
	    						<?php
	    						return
	    					?>
	    				</td>
	    			</tr>
	    		<?php
	    	}
	    	?>
		</table>
        </body>
    </div>
</div>