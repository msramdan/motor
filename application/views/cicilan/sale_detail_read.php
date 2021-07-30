<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
    <body>
        <h2 style="margin-top:0px">Kelola Data Cicilan</h2>
        <table class="table">
        	<tr>
        		<th>Pembayaran ke</th>
        		<th>Status</th>
        		<th>Nominal Bayar</th>
        	</tr>
	    	<?php
	    	foreach($list_cicilan as $lc) {
	    		?>
	    			<tr>
	    				<td><?php echo $lc->pembayaran_ke ?></td>
	    				<td><?php echo $lc->harus_dibayar ?></td>
	    				<td>
	    					<div class="bton-action" style="position: relative;
							    z-index: 2;
							    background: white;
							    padding: 2px 0px 11px 0px;">
		    					<?php
		    						if ($lc->total_bayar == $lc->harus_dibayar) {
		    							?>
		    								<span>
		    									<button type="button" class="btn btn-success btn-xs">Lunas</button>
		    								</span>
		    								
		    							<?php
		    							
		    						} else if ($lc->total_bayar > 0 && $lc->total_bayar < $lc->harus_dibayar) {
		    							?>
		    								<span>
		    									<button type="button" class="btn btn-warning btn-xs">Pembayaran Kurang (dibayar = <?php echo $lc->total_bayar ?>)</button>
		    								</span>
		    								
		    							<?php
		    							
		    						} else if ($lc->total_bayar > $lc->harus_dibayar) {
		    							?>
		    								<span>
		    									<button type="button" class="btn btn-secondary btn-xs">Pembayaran Berlebih (dibayar = <?php echo $lc->total_bayar ?> )</button>
		    								</span>
		    								
		    							<?php
		    							
		    						} else {


		    						?>
		    							<span>
		    								<button type="button" class="btn btn-danger btn-xs">Belum Lunas</button>
		    							</span>
		    							
		    						<?php
		    						
		    						}

		    					?>
		    					<button type="button" class="btn btn-primary btn-sm btn-show-input"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
	    					</div>
                            <div class="input-group" style=" max-width: 220px;
							    transition: all 250ms ease-in-out;
							    margin-top: -6vh;
							    position: relative;
							    z-index: 1;
							    margin-bottom: 0;">
	                            <input type="text" class="form-control" value="<?php echo $lc->total_bayar ?>">
	                            <span class="input-group-btn container-submit-cicilan-action">
									<button type="button" class="btn btn-primary submit-cicilan"><i class="fa fa-check"></i></button>
									<input type="hidden" name="id_cicilan" class="id_cicilan" value="<?php echo $lc->sale_detail_id ?>">
								</span>
	                        </div>
	    				</td>
	    			</tr>
	    		<?php
	    	}
	    	?>
		</table>
        </body>
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

	$(document).ready(function() {
		$('.btn-show-input').on('click', function() {
			$(this).parents('div').next('.input-group').css('margin-top','0vh')
			$(this).css('display','none')
		})

		$('.submit-cicilan').on('click', function() {

			const thisel = $(this)

			thisel.html('<i class="fa fa-circle-o-notch fa-spin"></i>')
			thisel.attr('disabled','disabled')

			const id_cicilan = $(this).next().val()
			const bayar = $(this).parents('.container-submit-cicilan-action').prev().val()
			$.ajax({
	            type : "POST",
	            url  : "<?php echo base_url() ?>/Cicilan/update_cicilan",
	            data : {
	            	idcicilan:id_cicilan,
	            	valuecicilan:bayar
	            },
	            success: function(data){
	            	const dt = JSON.parse(data)
	            	thisel.parents('.input-group').prev('.bton-action').children('.btn-show-input').css('display','unset')
	            	thisel.parents('.input-group').prev('.bton-action').children('span').html(dt)
					thisel.parents('.input-group').css('margin-top','-6vh')

					thisel.html('<i class="fa fa-check"></i>')
	        		thisel.removeAttr('disabled')
	            }
	        });
		})
	})
</script>