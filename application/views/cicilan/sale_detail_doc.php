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
        <h2>Sale_detail List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Sale Id</th>
		<th>Pembayaran Ke</th>
		<th>Status</th>
		<th>Total Bayar</th>
		<th>Jatuh Tempo</th>
		
            </tr><?php
            foreach ($sale_detail_data as $sale_detail)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $sale_detail->sale_id ?></td>
		      <td><?php echo $sale_detail->pembayaran_ke ?></td>
		      <td><?php echo $sale_detail->status ?></td>
		      <td><?php echo $sale_detail->total_bayar ?></td>
		      <td><?php echo $sale_detail->jatuh_tempo ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>