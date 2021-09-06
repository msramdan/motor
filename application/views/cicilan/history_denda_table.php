<style type="text/css">
	.tabel-history-denda > tbody > tr:last-child
	{
		font-weight: bold;
	}
</style>
<?php

if ($historydenda) {
	?>
	<div class="alert alert-info">
		<p><b>Catatan :</b> Data paling bawah yang ditebalkan adalah pembayaran terakhir dilakukan, klik tombol <span><button class="btn btn-primary btn-xs"><i class="fa fa-print"></i></button></td></span> untuk mencetak kwitansi</p>
	</div>
	<table class="table tabel-history-denda">
		<tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>Nominal Bayar</th>
			<th>Status</th>
			<th></th>
		</tr>
		<?php
			$pep = 0;
			foreach($historydenda as $hd)
			{
				$pep = $pep + 1;
			?>
				<tr>
					<td><?php echo $pep ?></td>
					<td><?php echo $hd->tanggal_bayar ?></td>
					<td><?php echo $hd->total_bayar ?></td>
					<td><?php echo $hd->status ?></td>
					<td><a class="btn btn-primary btn-xs" href="<?php echo base_url().'r_cicilan/kwitansiCicilanDenda/'.$hd->pembayaran_detail_id.'/'.$idinvoice.'/'.$pembayaranke.'/'.$pep ?>"><i class="fa fa-print"></i></a></td>
				</tr>
				<?php
			}
		?>
	</table>
	<?php
}
else
{
	?>
	<table class="table">
		<tr>
			<td>Tidak ada data</td>
		</tr>
	</table>
	<?php
}
?>