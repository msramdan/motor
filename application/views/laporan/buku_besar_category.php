<div class="box-body" style="overflow-x: scroll; ">
    <table class="table table-bordered" style="margin-bottom: 10px">
        <tr>
	        <th rowspan="2">No</th>
			<th rowspan="2">Kelompok</th>
			<th colspan="2">Saldo Awal</th>
			<th colspan="2">Angsuran</th>
			<th colspan="2">Saldo Akhir</th>
			<th colspan="2">Presentase</th>
	    </tr>
	    <tr>
	    	<th>Pokok</th>
	    	<th>Bunga</th>
	    	<th>Pokok</th>
	    	<th>Bunga</th>
	    	<th>Pokok</th>
	    	<th>Bunga</th>
	    	<th>Pokok</th>
	    	<th>Bunga</th>
	    </tr>
	    <?php
        
        $arrkategori = ['Lancar', 'Kurang Lancar', 'Diragukan' ,'Macet'];

        $no = 0;

        foreach ($arrkategori as $a)
        {

        	$class = '';
        	$url = '';

        	if ($a === 'Lancar') {
        		$class = 'btn btn-success btn-xs';
        		$url = 'Lap_buku_besar/list_data/list_lancar';
        	}

        	if ($a === 'Kurang Lancar') {
        		$class = 'btn btn-warning btn-xs';
        		$url = 'Lap_buku_besar/list_data/list_kurang_lancar';
        	}

        	if ($a === 'Diragukan') {
        		$class = 'btn btn-danger btn-xs';
        		$url = 'Lap_buku_besar/list_data/list_diragukan';
        	}

        	if ($a === 'Macet') {
        		$class = 'btn btn-danger btn-xs';
        		$url = 'Lap_buku_besar/list_data/list_macet';
        	}
		?>
		<tr>
			<td width="10px"><?php echo ++$no ?></td>
			<td><a href="<?php echo base_url().$url ?>" class="<?php echo $class ?>"><?php echo $a ?></a></td>
			<td><?php echo $classnyak->getDataSaldoAwalBB($a)->Pokok ?></td>
			<td><?php echo $classnyak->getDataSaldoAwalBB($a)->Bunga ?></td>
			<td><?php echo $classnyak->getDataAngsuranBB($a)->Pokok ?></td>
			<td><?php echo $classnyak->getDataAngsuranBB($a)->Bunga ?></td>
			<td><?php echo $classnyak->getDataSaldoAkhirBB($a)->Pokok ?></td>
			<td><?php echo $classnyak->getDataSaldoAkhirBB($a)->Bunga ?></td>
			<td>a</td>
			<td>a</td>
		</tr>
            <?php
        }
        ?>
    </table>
</div>