<?php echo show_button($this->uri->segment(1), 'export','?from='.$fromDate.'&to='.$toDate); ?>
<div class="box-body" style="overflow-x: scroll; ">
	<table class="table table-bordered table-striped" style="margin-bottom: 10px">
		<tr>
			<th rowspan="2">No</th>
	        <th rowspan="2">Invoice</th>
	        <th colspan="6">item</th>
	        <th rowspan="2">Surveyor</th>
	        <th colspan="2">Lokasi</th>
	        <th rowspan="2">Nama Pelanggan</th>
	        <th rowspan="2">ID Pelanggan</th>
	        <th colspan="2">Waktu</th>
	        <th rowspan="2">DP</th>
	        <th rowspan="2">TradeIn</th>
	        <th rowspan="2">Harga Beli Pokok</th>
	        <th rowspan="2">Harga Penjualan</th>
	        <th rowspan="2">Markup</th>
	        <th rowspan="2">Sales Pokok</th>
	        <th rowspan="2">Durasi Cicil</th>
	        <th rowspan="2">Bunga/bln</th>
		</tr>
		<tr>
			<th>ID Item</th>
			<th>Merek</th>
			<th>Type</th>
			<th>STNK</th>
			<th>Kategori</th>
			<th>Jenis</th>
			<th>Unit</th>
	        <th>Wipem</th>
	        <th>Tanggal</th>
			<th>Jam</th>
		</tr>


		<?php
		if ($lists_data) {
			$no = 0;
		foreach($lists_data as $data)
	        {

	           echo '<tr>';
	           echo '<td>'.++$no.'</td>';
	           echo '<td>'.$data->invoice.'</td>';
	           echo '<td>'.$data->item_id.'</td>';
	           echo '<td>'.$data->nama_merek.'</td>';
	           echo '<td>'.$data->nama_type.'</td>';
	           echo '<td>'.$data->no_stnk.'</td>';
	           echo '<td>'.$data->nama_kategori.'</td>';
	           echo '<td>'.$data->nama_jenis_item.'</td>';
	           echo '<td>'.$data->nama_karyawan.'</td>';
	           echo '<td>'.$data->nama_unit.'</td>';
	           echo '<td>'.$data->nama_unit.'</td>';
	           echo '<td>'.$data->nama_pelanggan.'</td>';
	           echo '<td>'.$data->pelanggan_id.'</td>';
	           echo '<td>'.$data->tanggal_sale.'</td>';
	           echo '<td>'.$data->tanggal_sale.'</td>';
	           echo '<td>'.$classnyak->History_pembayaran_model->getSingleDataHistoryPembayaran($data->invoice, 'dp cicilan')->total_bayar.'</td>';
	           echo '<td>'.$data->harga_beli.'</td>';
	           echo '<td>'.$data->harga_pokok.'</td>';
	           echo '<td>'.$data->total_bayar.'</td>';
	           echo '<td>'.(intval($data->total_bayar) - intval($data->harga_pokok)).'</td>';
	           echo '<td>'.$data->total_price_sale.'</td>';
	           echo '<td>'.$classnyak->Sale_model->get_bungapercicilan($data->invoice)->brapaxcicilan.'</td>';
	           echo '<td>'.$classnyak->Sale_model->get_bungapercicilan($data->invoice)->nilai_bunga_percicilan.'</td>';
	           echo '</tr>';
	        }
		}
		else
		{
			?>
			<tr>
				<td colspan="23" align="center">Tidak ada Data</td>
			</tr>
			<?php
		}
		?>
	</table>
</div>