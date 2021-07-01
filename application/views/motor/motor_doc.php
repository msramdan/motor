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
        <h2>Motor List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Kd Motor</th>
		<th>Nama Motor</th>
		<th>Merek Id</th>
		<th>Deskripsi</th>
		<th>Stok</th>
		<th>Photo</th>
		
            </tr><?php
            foreach ($motor_data as $motor)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $motor->kd_motor ?></td>
		      <td><?php echo $motor->nama_motor ?></td>
		      <td><?php echo $motor->merek_id ?></td>
		      <td><?php echo $motor->deskripsi ?></td>
		      <td><?php echo $motor->stok ?></td>
		      <td><?php echo $motor->photo ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>