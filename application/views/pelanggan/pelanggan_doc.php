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
		<th>No Ktp</th>
		<th>No Kk</th>
		<th>Nama Pelanggan</th>
		<th>No Hp Pelanggan</th>
		<th>Jenis Kelamin</th>
		<th>Alamat Ktp</th>
		<th>Alamat Domisili</th>
		<th>Nama Saudara</th>
		<th>Alamat Saudara</th>
		<th>No Hp Saudara</th>
		
            </tr><?php
            foreach ($pelanggan_data as $pelanggan)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $pelanggan->no_ktp ?></td>
		      <td><?php echo $pelanggan->no_kk ?></td>
		      <td><?php echo $pelanggan->nama_pelanggan ?></td>
		      <td><?php echo $pelanggan->no_hp_pelanggan ?></td>
		      <td><?php echo $pelanggan->jenis_kelamin ?></td>
		      <td><?php echo $pelanggan->alamat_ktp ?></td>
		      <td><?php echo $pelanggan->alamat_domisili ?></td>
		      <td><?php echo $pelanggan->nama_saudara ?></td>
		      <td><?php echo $pelanggan->alamat_saudara ?></td>
		      <td><?php echo $pelanggan->no_hp_saudara ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>