<div class="box-body" style="overflow-x: scroll; ">
	<h2 style="font-size: 16px;">Piutang Global <?php echo $dataunit->nama_grup ?></h2>
	<h2 style="font-size: 16px;"><?php echo $dataunit->nama_unit ?></h2>
	<h3 style="font-size: 13px;"><?php echo $dataunit->alamat_unit ?></h3>
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

        $no = 1;

        $sumSABBP = 0;
        $sumSABBB = 0;

        $sumABBP = 0;
        $sumABBB = 0;

        $sumSAKHBBP = 0;
        $sumSAKHBBB = 0;

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
			<td width="10px"><?php echo $no ?></td>
			<td><a href="<?php echo base_url().$url ?>" class="<?php echo $class ?>"><?php echo $a ?></a></td>
			<td><?php
				echo $classnyak->getDataSaldoAwalBB($a)->Pokok;
				$sumSABBP += $classnyak->getDataSaldoAwalBB($a)->Pokok;
			?></td>
			<td><?php
				echo $classnyak->getDataSaldoAwalBB($a)->Bunga;
				$sumSABBB += $classnyak->getDataSaldoAwalBB($a)->Bunga;
			?></td>
			<td><?php
				echo $classnyak->getDataAngsuranBB($a)->Pokok;
				$sumABBP += $classnyak->getDataAngsuranBB($a)->Pokok;
			?></td>
			<td><?php
				echo $classnyak->getDataAngsuranBB($a)->Bunga;
				$sumABBB += $classnyak->getDataAngsuranBB($a)->Bunga
			?></td>
			<td id="sapokokrow<?php echo $no ?>"><?php
				echo $classnyak->getDataSaldoAkhirBB($a)->Pokok;
				$sumSAKHBBP += $classnyak->getDataSaldoAkhirBB($a)->Pokok
			?></td>
			<td id="sabungarow<?php echo $no ?>"><?php
				echo $classnyak->getDataSaldoAkhirBB($a)->Bunga;
				$sumSAKHBBB += $classnyak->getDataSaldoAkhirBB($a)->Bunga
			?></td>
			<td id="precentagepokokrow<?php echo $no ?>"><i class="fa fa-spinner fa-spin"></i></td>
			<td id="precentagebungarow<?php echo $no ?>"><i class="fa fa-spinner fa-spin"></i></td>
		</tr>
            <?php
            ++$no;
        }
        ?>
		<tr>
        	<td colspan="2">Total</td>
        	<td id="total1"><?php echo $sumSABBP ?></td>
        	<td id="total2"><?php echo $sumSABBB ?></td>
        	<td id="total3"><?php echo $sumABBP ?></td>
        	<td id="total4"><?php echo $sumABBB ?></td>
        	<td id="total5"><?php echo $sumSAKHBBP ?></td>
        	<td id="total6"><?php echo $sumSAKHBBB ?></td>
        	<td id="total7">100%</td>
        	<td id="total8">100%</td>
        </tr>
    </table>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		let tota = $('#total5').text()
		let totb = $('#total6').text()
		for (var i = 1; i <= 4; i++) {
			let amounta = $('#sapokokrow' + i).text()
			let amountb = $('#sabungarow' + i).text()

			$('#precentagepokokrow' + i).text(((amounta/tota) * 100).toFixed(2) + '%')
			$('#precentagebungarow' + i).text(((amountb/totb) * 100).toFixed(2) + '%')
		}

	})
</script>