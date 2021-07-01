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
        <h2>Pelanggan List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Ktp</th>
		<th>Nama Pelanggan</th>
		<th>No Hp Pelanggan</th>
		<th>Jenis Kelamin</th>
		<th>Alamat</th>
		
            </tr><?php
            foreach ($pelanggan_data as $pelanggan)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $pelanggan->ktp ?></td>
		      <td><?php echo $pelanggan->nama_pelanggan ?></td>
		      <td><?php echo $pelanggan->no_hp_pelanggan ?></td>
		      <td><?php echo $pelanggan->jenis_kelamin ?></td>
		      <td><?php echo $pelanggan->alamat ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>