<table class="table">
	<tr>
		<th width="20px">Pembayaran ke</th>
		<th>Status</th>
		<th>Nominal Bayar</th>
		<th>Tanggal Dibayar</th>
		<th>Penginput</th>
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
										<span class="status">
											<button type="button" class="btn btn-success btn-xs">Lunas</button>
										</span>
										
									<?php
									
								} else if ($lc->total_bayar > 0 && $lc->total_bayar < $lc->harus_dibayar) {
									?>
										<span class="status">
											<button type="button" class="btn btn-warning btn-xs">Pembayaran Kurang (dibayar = <?php echo $lc->total_bayar ?>)</button>
										</span>
										
									<?php
									
								} else if ($lc->total_bayar > $lc->harus_dibayar) {
									?>
										<span class="status">
											<button type="button" class="btn btn-secondary btn-xs">Pembayaran Berlebih (dibayar = <?php echo $lc->total_bayar ?> )</button>
										</span>
										
									<?php
									
								} else {


								?>
									<span class="status">
										<button type="button" class="btn btn-danger btn-xs">Belum Lunas</button>
									</span>
									
								<?php
								
								}

							?>
							<?php
							if ($lc->total_bayar == $lc->harus_dibayar) {
								?>
								<a type="button" class="btn btn-primary btn-xs" href="<?php echo base_url().'r_cicilan/kwitansi/'.$lc->pembayaran_ke.'/'.$lc->sale_id ?>"><i class="fa fa-print"></i></a>
								<?php
							} else {
								?>
									<button type="button" class="btn btn-primary btn-xs btn-show-input"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
								<?php
							}
							?>
							<span class="button-bayar-cicilan-wrapper"></span>
						</div>
						<?php
							if ($lc->total_bayar != $lc->harus_dibayar) {
								?>
								<div class="input-group" style=" max-width: 220px;
								    transition: all 250ms ease-in-out;
								    margin-top: -6vh;
								    position: relative;
								    z-index: 1;
								    margin-bottom: 0;">
								    <input type="hidden" name="pembayaranke" id="pembayaranke" value="<?php echo $lc->pembayaran_ke ?>">
				                    <input type="text" class="form-control" value="<?php echo $lc->total_bayar ?>">
				                    <span class="input-group-btn container-submit-cicilan-action">
										<button type="button" class="btn btn-primary submit-cicilan"><i class="fa fa-check"></i></button>
										<button type="button" class="btn btn-danger cancel-input-cicilan"><i class="fa fa-times"></i></button>
										<input type="hidden" name="id_cicilan" class="id_cicilan" value="<?php echo $lc->sale_detail_id ?>">
									</span>
				                </div>
								<?php
							}
						?>
					</td>
					<td>
						<span class="txttgldibayar">
							<?php
								if ($lc->tanggal_dibayar === NULL) {
									echo '-';
								} else {
									echo $lc->tanggal_dibayar;	
								}
							?>
						</span>
					</td>
					<td>
						<span class="txtpenginput">
							<?php
								if ($lc->penginput) {	    							
									echo $lc->penginput;
								} else {
									echo '-';
								}
							?>
						</span>
					</td>
				</tr>
			<?php
		}
		?>
</table>
<div style="text-align: center; font-size: 24px; font-weight: bold;">
	<p class="warn-sisapembayaran"><span class="brapax"><?php echo $sisapembayaranbrapax ?></span> Pembayaran tersisa</p>
</div>