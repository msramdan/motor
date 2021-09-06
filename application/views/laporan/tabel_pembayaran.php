<?php echo show_button($this->uri->segment(1), 'export','?from='.$fromDate.'&to='.$toDate); ?>
<div class="box-body" style="overflow-x: scroll; ">
	<table class="table table-bordered table-striped" style="margin-bottom: 10px">
		<tr>
			<th rowspan="2">No</th>
	        <th colspan="2">Invoice</th>
	        <th rowspan="2">Invoice</th>
	        <th rowspan="2">Kategori</th>
	        <th colspan="2">Waktu</th>
	        <th rowspan="2">Detail Object</th>
	        <th rowspan="2">Jumlah</th>
	        <th rowspan="2">User</th>
		</tr>
		<tr>
			<th>Nama</th>
			<th>ID</th>
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
		           <td><?php echo $data->invoice ?></td> 
		           <td><?php echo $data->nama_kategori ?></td> 
		           <td><?php echo $data->tanggal_sale ?></td> 
		           <td><?php echo $data->tanggal_sale ?></td>
		           <td><?php echo $data->jenis_pembayaran ?></td>
		           <td><?php echo $data->total_bayar ?></td>
		           <td><?php echo $data->nama_user ?></td> 
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