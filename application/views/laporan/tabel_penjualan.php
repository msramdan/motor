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
	        	?>

	           <tr>
		           <td><?php echo ++$no ?></td>

		           <?php
		           if ($data->type_sale === 'Kredit') {
		           		?>
		           		<td><a href="<?php echo base_url().'r_cicilan/update/'.$data->invoice ?>"><?php echo $data->invoice ?></a></td>
		           		<?php
		           }

		           if ($data->type_sale === 'Cash') {
		           		?>
		           		<td><a href="<?php echo base_url().'r_onetimep/update/'.$data->invoice ?>"><?php echo $data->invoice ?></a></td>
		           		<?php
		           }
		           ?> 
		           <td><?php echo $data->item_id ?></td> 
		           <td><?php echo $data->nama_merek ?></td> 
		           <td><?php echo $data->nama_type ?></td> 
		           <td><?php echo $data->no_stnk ?></td> 
		           <td><?php echo $data->nama_kategori ?></td> 
		           <td><?php echo $data->nama_jenis_item ?></td> 
		           <td><?php echo $data->nama_karyawan ?></td> 
		           <td><?php echo $data->nama_unit ?></td> 
		           <td><?php echo $data->nama_unit ?></td> 
		           <td><?php echo $data->nama_pelanggan ?></td> 
		           <td><?php echo $data->pelanggan_id ?></td> 
		           <td><?php echo $data->tanggal_sale ?></td> 
		           <td><?php echo $data->tanggal_sale ?></td> 
		           <td><?php echo $classnyak->History_pembayaran_model->getSingleDataHistoryPembayaran($data->invoice, 'dp cicilan')->total_bayar ?></td> 
		           <td><?php echo $data->harga_beli ?></td> 
		           <td><?php echo $data->harga_pokok ?></td> 
		           <td><?php echo $data->total_bayar ?></td> 
		           <td><?php echo (intval($data->total_bayar) - intval($data->harga_pokok)) ?></td> 
		           <td><?php echo $data->total_price_sale ?></td> 
		           <td><?php echo $classnyak->Sale_model->get_bungapercicilan($data->invoice)->brapaxcicilan ?></td> 
		           <td><?php echo $classnyak->Sale_model->get_bungapercicilan($data->invoice)->nilai_bunga_percicilan ?></td> 
	           </tr>
	           <?php
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