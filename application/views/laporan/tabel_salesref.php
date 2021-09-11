<?php echo show_button($this->uri->segment(1), 'export','?from='.$fromDate.'&to='.$toDate.'&namasalesreferral='.$namasalesreferral.'&jenissalesreferral='.$jenissalesreferral); ?>
<div class="box-body" style="overflow-x: scroll; ">
	<table class="table table-bordered table-striped table-report" style="margin-bottom: 10px">
		<tr>
			<th rowspan="2">No</th>
	        <th colspan="2">Customer</th>
	        <th colspan="3">Sales Ref</th>
	        <th rowspan="2">Invoice</th>
	        <th colspan="2">Waktu</th>
	        <th rowspan="2">Sales Pokok</th>
	        <th rowspan="2">Bunga Angsuran</th>
	        <th rowspan="2">Harga Nominal</th>
	        <th rowspan="2">Durasi Cicil</th>
		</tr>
		<tr>
			<th>Nama</th>
			<th>ID</th>
			<th>Nama</th>
			<th>ID</th>
			<th>Kategori</th>
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
		           <td><?php echo $data->nama_pelanggan ?></td>
		           <td><?php echo $data->pelanggan_id ?></td>
		           
		           <td><?php 
		           if ($data->sales_referral == 'Mitra Sales') {
						echo $classnyak->getNamaMitra($data->contact_id)->nama_mitra;
		           } 
		           else if($data->sales_referral == 'Karyawan')
		           {
		           		echo $classnyak->getNamaKaryawan($data->contact_id)->nama_karyawan;
		           }
		           else
		           {
		           		echo '-';
		           }

		       		?></td>
		       		<td><?php echo $data->contact_id ?></td>
		       		<td><?php echo $data->sales_referral ?></td>
		           	<td><?php echo $data->invoice ?></td>
		           	<td><?php echo $data->tanggal_sale ?></td>
		           	<td><?php echo $data->tanggal_sale ?></td>
		           	<td><?php echo $data->total_price_sale ?></td>

		           	<td><?php echo (intval($data->total_bayar) - intval($data->harga_pokok)) ?></td>

		           	<td><?php echo $data->total_bayar ?></td>

		           	<td><?php echo $classnyak->Sale_model->get_bungapercicilan($data->invoice)->brapaxcicilan ?></td>

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