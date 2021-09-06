<?php
if ($dataa) {

	$wh = json_decode($dataa->approve_by, true);
	foreach ($wh as $key => $value) {
		if ($value == '-') {
			?>
			<div style="text-align: center;">
				<div style="position: relative;">
					<i class="fa fa-users" style="font-size: 67px;"></i>
					<i class="fa fa-minus" style="font-size: 27px; position: absolute; bottom: 0;"></i>
				</div>
				<h3><?php echo $key ?></h3>

				<p><label class="label label-default">Dalam Review</label></p>
			</div>
			<?php
		}

		if ($value == 'true') {
			?>
			<div style="text-align: center;">
				<div style="position: relative;">
					<i class="fa fa-users" style="font-size: 67px;"></i>
					<i class="fa fa-check-circle" style="font-size: 27px; color: green; position: absolute; bottom: 0;"></i>
				</div>
				<h3><?php echo $key ?></h3>

				<p><label class="label label-success">Disetujui</label></p>
			</div>
			<?php
		}

		if ($value == 'false') {
			?>
			<div style="text-align: center;">
				<div style="position: relative;">
					<i class="fa fa-users" style="font-size: 67px;"></i>
					<i class="fa fa-times-circle" style="font-size: 27px; color: red; position: absolute; bottom: 0;"></i>
				</div>
				<h3><?php echo $key ?></h3>

				<p><label class="label label-danger">Ditolak</label></p>
			</div>
			<?php
		}
	}
} else {

	?>
	<form id="pengajuan_diskon_denda_form" method="post">
		<div class="alert alert-danger">
			<p><b>Perhatian:</b> Input dalam bentuk jumlah rupiah atau persen (untuk input persen sertakan simbol %)</p>
		</div>
		<div class="input-group" style="
		    position: relative;
		    margin-bottom: 0;">
            <input type="number" class="form-control" name="tbjumlahdiskon" placeholder="Contoh: 2.5% atau 25000">
            <input name="invoicehidden" type="hidden" value="<?php echo $invoice ?>">
        <input name="cicilanke" type="hidden" value="<?php echo $pembayaranke ?>">
        <input name="idcicilan" type="hidden" value="<?php echo $idcicilan ?>">
            <span class="input-group-btn container-submit-cicilan-action">
				<button type="submit" class="btn btn-primary">Submit</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
			</span>
        </div>
	</form>
	<?php
}

?>
