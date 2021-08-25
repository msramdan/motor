<table class="table">
	<tr>
		<th width="20px">Pembayaran ke</th>
		<th>Nominal Bayar</th>
		<th>Status</th>
		<th>Tanggal Dibayar</th>
		<th>Penginput</th>
		<th></th>
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
							<span class="button-bayar-denda-wrapper">
								<?php
									$den = $classnyak->cekDenda($lc->sale_detail_id);
									if (is_array($den)) 
									{
										?>
										<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal<?php echo $lc->pembayaran_ke ?>"><i class="fa fa-warning"></i></button>
										<?php
									}
								?>

							</span>
						</div>
						<?php
							if ($lc->total_bayar != $lc->harus_dibayar) {
								?>
								<div class="input-group" style=" max-width: 220px;
								    transition: all 250ms ease-in-out;
								    margin-top: -40px;
								    position: relative;
								    z-index: 1;
								    margin-bottom: 0;">
								    <input type="hidden" name="pembayaranke" id="pembayaranke" value="<?php echo $lc->pembayaran_ke ?>">
				                    <input type="text" class="form-control" value="<?php echo $lc->total_bayar ?>">
				                    <span class="input-group-btn container-submit-cicilan-action">
										<button type="button" class="btn btn-primary submit-cicilan"><i class="fa fa-check" style="margin: 0;"></i></button>
										<button type="button" class="btn btn-danger cancel-input-cicilan"><i class="fa fa-times"></i></button>
										<input type="hidden" name="id_cicilan" class="id_cicilan" value="<?php echo $lc->sale_detail_id ?>">
										<input type="hidden" name="invoicehidden" value="<?php echo $lc->sale_id ?>">
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
					<td>
						<div class="x_content">
		                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm" type="button" aria-expanded="false"><i class="fa fa-bars"></i> <span class="caret"></span></button>
		                    <ul role="menu" class="dropdown-menu">
							<?php
							if ($lc->total_bayar != $lc->harus_dibayar) {
								?>
								<li><a class="btn-show-input">Bayar</a></li>
								<?php
							}

							?>
							<?php
							if ($lc->total_bayar > 0) {
								?>
									<li><a href="<?php echo base_url().'r_cicilan/kwitansiBayarCicilan/'.$lc->sale_detail_id.'/'.$lc->sale_id.'/'.$lc->pembayaran_ke ?>">Cetak Kwitansi Cicilan</a></li>
								<?php
							}
							?>
							<li class="divider"></li>
							<?php
								$den = $classnyak->cekDenda($lc->sale_detail_id);
								if (is_array($den) || $den == 'denda lunas') 
								{
									if ($den == 'denda lunas') {
										?>
										<li><a href="<?php echo base_url().'r_cicilan/kwitansiBayardenda/'.$lc->pembayaran_ke.'/'.$lc->sale_id ?>">Cetak Kwitansi Denda</a></li>
										<li><a href="#" data-toggle="modal" data-target="#modalhistorydenda<?php echo $lc->pembayaran_ke ?>">History Bayar Denda</a></li>
										<?php
									}
									else
									{
										?>
										<li><a href="#" data-toggle="modal" data-target="#modalbayardenda<?php echo $lc->pembayaran_ke ?>">Bayar Denda</a></li>
										<li><a href="#" data-toggle="modal" data-target="#modalhistorydenda<?php echo $lc->pembayaran_ke ?>">History Bayar Denda</a></li>
										<li><a href="#" data-toggle="modal" data-target="#modaldiskondenda<?php echo $lc->pembayaran_ke ?>">Diskon Denda</a></li>
										<?php	
									}
								}
							?>
							<li><a href="#">Detail</a></li>
		                    </ul>
		                </div>
					</td>
				</tr>
			<?php
		}
		?>
</table>
<div style="text-align: center; font-size: 24px; font-weight: bold;">
	<p class="warn-sisapembayaran"><span class="brapax"><?php echo $sisapembayaranbrapax ?></span> Pembayaran tersisa</p>
</div>

<?php
	foreach($list_cicilan as $lc) {
		$den = $classnyak->cekDenda($lc->sale_detail_id);

		if($den == 'denda lunas')
		{
			?>
			<div class="modal fade" id="modalhistorydenda<?php echo $lc->pembayaran_ke ?>" tabindex="-1" role="dialog" aria-hidden="true">
	            <div class="modal-dialog modal-sm">
	              <div class="modal-content">

	                <div class="modal-header">
	                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
	                  </button>
	                  <h4 class="modal-title" id="myModalLabel2">History Bayar Denda</h4>
	                </div>
	                <div class="modal-body">
	                <?php
            			$classnyak->get_history_denda($lc->sale_id, $lc->pembayaran_ke);
            		?>
	                </div>
	                <div class="modal-footer">
	                  <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
	                </div>

	              </div>
	            </div>
	        </div>

	        <div class="modal fade" id="modaldiskondenda<?php echo $lc->pembayaran_ke ?>" tabindex="-1" role="dialog" aria-hidden="true">
	            <div class="modal-dialog modal-sm">
	              <div class="modal-content">
	              	<form id="pengajuan_diskon_denda_form" method="post">
		                <div class="modal-header">
		                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
		                  </button>
		                  <h4 class="modal-title" id="myModalLabel2">History Bayar Denda</h4>
		                </div>
		                <div class="modal-body">
		                	<input type="hidden" name="cicilanke" value="<?php echo $lc->pembayaran_ke ?>">
	                		<input type="hidden" name="invoicehidden" value="<?php echo $lc->sale_id ?>">
	                		<input type="hidden" name="idcicilan" value="<?php echo $lc->sale_detail_id ?>">
		                <?php
		                	$l = $classnyak->cekApprovalDiskonDenda($lc->sale_detail_id,$lc->pembayaran_ke,$invoice);
		                	if ($l === 'no data') {
		                		echo 'no dataaa';
		                	} else {
		                		$classnyak->cekApprovalDiskonDenda($lc->sale_detail_id,$lc->pembayaran_ke,$invoice);
		                	}
	            		?>
		                </div>
		                <div class="modal-footer">
		                  <button type="submit" class="btn btn-primary" data-dismiss="modal">Submit</button>
		                </div>
		            </form>
	              </div>
	            </div>
	        </div>
			<?php
		}

		if (is_array($den))
		{
			?>
			<div class="modal fade" id="modalbayardenda<?php echo $lc->pembayaran_ke ?>" tabindex="-1" role="dialog" aria-hidden="true">
	            <div class="modal-dialog modal-sm">
	              <div class="modal-content">
	              	<form id="bayar_denda_form" method="post">
		                <div class="modal-header">
		                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
		                  </button>
		                  <h4 class="modal-title" id="myModalLabel2">Bayar Denda</h4>
		                </div>
		                <div class="modal-body">
	                		<div class="warningalert">
	                			
	                		</div>
	                		<table>
	                			<tr>
	                				<td>Wajib dibayar</td>
	                				<td>:</td>
	                				<td><?php echo $den['jumlah_denda'] ?></td>
	                			</tr>
	                			<tr>
	                				<td>Telah dibayar</td>
	                				<td>:</td>
	                				<td><?php echo $den['dibayar'] ?></td>
	                			</tr>
	                		</table>
	                		<input type="hidden" name="cicilanke" value="<?php echo $lc->pembayaran_ke ?>">
	                		<input type="hidden" name="invoicehidden" value="<?php echo $lc->sale_id ?>">
	                		<input type="hidden" name="idcicilan" value="<?php echo $lc->sale_detail_id ?>">
	                		<input type="number" name="tbjumlahbayar" placeholder="Masukan jumlah bayar">
		                  <p style="font-style: italic; font-size: 11px; color: red;">*Pastikan sebelum input dan print kwitansi, pembayaran denda sudah diterima</p>
		                </div>
		                <div class="modal-footer">
		                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		                  <button type="submit" class="btn btn-primary" id="submit_bayar">Bayar</button>
		                </div>
					</form>
	              </div>
	            </div>
	        </div>

	        <div class="modal fade" id="modal<?php echo $lc->pembayaran_ke ?>" tabindex="-1" role="dialog" aria-hidden="true">
	            <div class="modal-dialog modal-sm">
	              <div class="modal-content">

	                <div class="modal-header">
	                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
	                  </button>
	                  <h4 class="modal-title" id="myModalLabel2">Peringatan Bayar Denda</h4>
	                </div>
	                <div class="modal-body">
	                  <p><label class="label label-danger"><?php echo $den['jumlah_telat_hari'] ?> Hari</label> terlewat dari jatuh tempo, adapun kewajiban bayar dendanya sebesar <b><?php echo $den['jumlah_denda'] ?></b></p>

	                  <p style="font-style: italic; font-size: 11px; color: red;">*Pastikan sebelum print kwitansi, pembayaran denda sudah diterima</p>
	                </div>
	                <div class="modal-footer">
	                  <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
	                </div>

	              </div>
	            </div>
	        </div>

	        <div class="modal fade" id="modalhistorydenda<?php echo $lc->pembayaran_ke ?>" tabindex="-1" role="dialog" aria-hidden="true">
	            <div class="modal-dialog modal-sm">
	              <div class="modal-content">

	                <div class="modal-header">
	                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
	                  </button>
	                  <h4 class="modal-title" id="myModalLabel2">History Bayar Denda</h4>
	                </div>
	                <div class="modal-body">
	                <?php
            			$classnyak->get_history_denda($lc->sale_id, $lc->pembayaran_ke);
            		?>
	                </div>
	                <div class="modal-footer">
	                  <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
	                </div>

	              </div>
	            </div>
	        </div>

	        <div class="modal fade" id="modaldiskondenda<?php echo $lc->pembayaran_ke ?>" tabindex="-1" role="dialog" aria-hidden="true">
	            <div class="modal-dialog modal-sm">
	              <div class="modal-content">
	                <div class="modal-header">
	                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
	                  </button>
	                  <h4 class="modal-title" id="myModalLabel2">Pengajuan Diskon Denda</h4>
	                </div>
	                <div class="modal-body">
	                	<input type="hidden" name="cicilanke" value="<?php echo $lc->pembayaran_ke ?>">
                		<input type="hidden" name="invoicehidden" value="<?php echo $lc->sale_id ?>">
                		<input type="hidden" name="idcicilan" value="<?php echo $lc->sale_detail_id ?>">
	                <?php
	                		$classnyak->cekApprovalDiskonDenda($lc->sale_detail_id,$lc->pembayaran_ke,$lc->sale_id);
            		?>
	                </div>
	              </div>
	            </div>
	        </div>
			<?php
		}
	}
?>