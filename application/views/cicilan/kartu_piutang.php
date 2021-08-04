<div class="row">
	<div class="col-md-6">
		<div class="x_panel">
	        <h2 style="margin-top:0px">Overview</h2>
	        <table class="table">
			    <tr><td>Invoice</td><td><?php echo $invoice; ?></td></tr>
			    <tr><td><b>Pelanggan</b></td><td><?php echo $nama_pelanggan; ?></td></tr>
			    <tr><td><b>Alamat</b></td><td><?php echo $alamat_domisili; ?></td></tr>
			    <tr><td>Jenis Barang</td><td><?php echo $nama_jenis_item; ?></td></tr>
			    <tr><td>Merk</td><td><?php echo $nama_merek; ?></td></tr>
			    <tr><td>Type</td><td><?php echo $nama_type; ?></td></tr>
			    <tr><td>No. BPKB</td><td><?php echo $no_bpkb; ?></td></tr>
			    <tr><td>Warna</td><td><?php echo $warna1.'/'.$warna2; ?></td></tr>
			</table>
	    </div>
	</div>

	<div class="col-md-6">
		<div class="x_panel">
			<h2 style="margin-top:0px">Info Pembayaran</h2>
			<table class="table" style="margin-top: 10px;">
	        	<tr><td>Harga Nominal</td><td>: </td><td><?php echo $total_price_sale; ?></td></tr>
	        	<tr><td>Pokok Kredit</td><td>: </td><td><?php echo $bunga_cicilan->pokok_cicilan.' + '.$bunga_cicilan->nilai_bunga_percicilan.'%'; ?></td></tr>
	        	<tr><td>Angsuran/bulan</td><td>: </td><td><?php echo $bunga_cicilan->harus_dibayar ?></td></tr>
	        	<tr><td>Jangka Waktu</td><td>: </td><td><?php echo $bunga_cicilan->brapaxcicilan.' Bulan'; ?></td></tr>
	        	<tr><td>Tanggal Pembayaran</td><td>: </td><td><?php echo 'Setiap tanggal '. $bunga_cicilan->tiap_tanggal; ?></td></tr>
	        </table>
	    </div>
	</div>
</div>
<a href="<?php echo base_url() ?>sale/cetak_faktur/<?php echo $sale_id ?>" class="btn btn-warning">Cetak</a>
<div>
	<table class="table table-striped table-bordered">
		<tr>
			<th rowspan="2" style="vertical-align: inherit;">No</th>
			<th rowspan="2" style="vertical-align: inherit;">Jatuh Tempo</th>
			<th colspan="3">Angsuran</th>
			<th colspan="2">Saldo Piutang</th>
			<th rowspan="2" style="vertical-align: inherit;">Keterangan</th>
		</tr>
		<tr>
			<th>Nominal</th>
			<th>Pokok</th>
			<th>Bunga</th>
			<th>Pokok</th>
			<th>Bruto</th>
		</tr>
		<?php


			$pokok =  $data_cicilan[0]->pokok_cicilan * sizeof($data_cicilan);
			$bruto =  $data_cicilan[0]->harus_dibayar * sizeof($data_cicilan);

			$no = 1;
			foreach ($data_cicilan as $v) {
				
				?>
				<tr>
					<td><?php echo $no++ ?></td>
					<td><?php echo date("d/m/Y", strtotime($v->jatuh_tempo)) ?></td>
					<td><?php echo $v->harus_dibayar ?></td>
					<td><?php echo $v->pokok_cicilan ?></td>
					<td><?php echo $v->harus_dibayar - $v->pokok_cicilan; ?></td>
					<td><?php echo $pokok -= $v->pokok_cicilan ?></td>
					<td><?php echo $bruto -= $v->harus_dibayar ?></td>
					<td><?php echo $v->status ?></td>
				</tr>
				<?php
			}
		?>
	</table>
</div>