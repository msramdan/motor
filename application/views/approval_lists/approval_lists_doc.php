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
        <h2>Approval_lists List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Invoice Id</th>
		<th>Approve By</th>
		<th>Approval Status</th>
		<th>Keterangan</th>
		<th>Komentar</th>
		
            </tr><?php
            foreach ($approval_lists_data as $approval_lists)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $approval_lists->invoice_id ?></td>
		      <td><?php echo $approval_lists->approve_by ?></td>
		      <td><?php echo $approval_lists->approval_status ?></td>
		      <td><?php echo $approval_lists->keterangan ?></td>
		      <td><?php echo $approval_lists->komentar ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>