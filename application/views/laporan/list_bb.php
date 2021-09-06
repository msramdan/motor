<div class="box-body" style="overflow-x: scroll; ">
    <table class="table table-bordered" style="margin-bottom: 10px">
        <tr>
	        <th rowspan="2">No</th>
			<th colspan="2">Customer</th>
			<th rowspan="2">Invoice</th>
			<th rowspan="2">Nominal</th>
			<th rowspan="2">Angsuran</th>
			<th colspan="2">Saldo Piutang</th>
	    </tr>
	    <tr>
	    	<th>Nama</th>
	    	<th>ID</th>
	    	<th>Pokok</th>
	    	<th>Bruto</th>
	    </tr>
	    <?php

        $no = 0;

        if ($lists_data) {
        	foreach ($lists_data as $a)
	        {
			?>
			<tr>
				<td width="10px"><?php echo ++$no ?></td>
				<td><?php echo $a->nama_pelanggan ?></td>
				<td><?php echo $a->pelanggan_id ?></td>
				<td><a href="<?php echo base_url().'R_cicilan/kartuPiutang/'.$a->invoice ?>"><?php echo $a->invoice ?></a></td>
				<td><?php echo $a->total_bayar ?></td>
				<td><?php echo $a->dibayar ?></td>
				<td><?php echo $classnyak->getPokokInvoiceterkini($a->invoice) ?></td>
				<td><?php echo $classnyak->getBrutoInvoiceterkini($a->invoice) ?></td>
			</tr>
	            <?php
	        }
        } else {
        	?>
        	<tr>
        		<td colspan="8" align="center">No Data</td>
        	</tr>
        	<?php
        }
        ?>
    </table>
    <div class="row">
        <div class="col-md-6">
            
        </div>
        <div class="col-md-6 text-right">
            <?php echo $pagination ?>
        </div>
    </div>
</div>