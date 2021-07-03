<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>Sale List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Invoice</th>
		<th>Pelanggan Id</th>
		<th>Kendaraan Id</th>
		<th>Total Price Sale</th>
		<th>Type Sale</th>
		<th>Tanggal Sale</th>
		<th>User Id</th>
		
            </tr><?php
            foreach ($sale_data as $sale)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $sale->invoice ?></td>
		      <td><?php echo $sale->pelanggan_id ?></td>
		      <td><?php echo $sale->kendaraan_id ?></td>
		      <td><?php echo $sale->total_price_sale ?></td>
		      <td><?php echo $sale->type_sale ?></td>
		      <td><?php echo $sale->tanggal_sale ?></td>
		      <td><?php echo $sale->user_id ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>