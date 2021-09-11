<div class="box-body" style="overflow-x: scroll; ">
	<table class="table table-bordered table-striped" style="margin-bottom: 10px">
		<tr>
			<th>No</th>
	        <th>Nama</th>
	        <th>Group Usaha</th>
	        <th>Unit</th>
	        <th>Kategori</th>
	        <th>Jenis</th>
	        <th>Durasi Cicil</th>
	        <th>Status</th>
	        <th>Angsuran Terakhir Ke</th>
	        <th>Keterlambatan Hari</th>
	        <th>Harga Nominal</th>
		</tr>



		<?php
		if ($lists_data) {
			$no = 0;
		foreach($lists_data as $data)
	        {
	        	?>

	           <tr>
		           <td><?php echo ++$no ?></td>
		           <td><a href="<?php echo base_url().'r_cicilan/kartupiutang/'.$data->invoice ?>"><?php echo $data->nama_pelanggan ?></a></td> 
		           <td><?php echo $data->nama_grup ?></td> 
		           <td><?php echo $data->nama_unit ?></td> 
		           <td><?php echo $data->nama_kategori ?></td> 
		           <td><?php echo $data->nama_jenis_item ?></td> 
		           <td><?php echo $classnyak->Sale_model->get_bungapercicilan($data->invoice)->brapaxcicilan ?></td>
		           <td><?php echo $data->keadaan_cicilan ?></td>
		           <td><?php
		           		$cek = $classnyak->getLastPaidCicilan($data->invoice);
		           		if ($cek) {
		           		  	echo $cek[0]->pembayaran_ke;
		           		  }
		           		  else{
		           		  	echo 'N/A';
		           		  }  ?></td>
		           <td><?php echo $classnyak->getTotalKeterlambatanHari($data->invoice)->total_telat_hari ?></td>
		           <td><?php echo $data->total_price_sale ?></td>
	           </tr>
	           <?php
	        }
		}
		else
		{
			?>
			<tr>
				<td colspan="11" align="center">Tidak ada Data</td>
			</tr>
			<?php
		}
		?>
	</table>
</div>