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
        <h2>Kendaraan List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Kd Pembelian</th>
		<th>Agen Id</th>
		<th>Kd Kendaraan</th>
		<th>Nama Kendaraan</th>
		<th>Jenis Kendaraan Id</th>
		<th>Merek Id</th>
		<th>No Stnk</th>
		<th>No Bpkb</th>
		<th>Deskripsi</th>
		<th>Harga Beli</th>
		<th>Photo</th>
		<th>Status</th>
		
            </tr><?php
            foreach ($kendaraan_data as $kendaraan)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $kendaraan->kd_pembelian ?></td>
		      <td><?php echo $kendaraan->agen_id ?></td>
		      <td><?php echo $kendaraan->kd_kendaraan ?></td>
		      <td><?php echo $kendaraan->nama_kendaraan ?></td>
		      <td><?php echo $kendaraan->jenis_kendaraan_id ?></td>
		      <td><?php echo $kendaraan->merek_id ?></td>
		      <td><?php echo $kendaraan->no_stnk ?></td>
		      <td><?php echo $kendaraan->no_bpkb ?></td>
		      <td><?php echo $kendaraan->deskripsi ?></td>
		      <td><?php echo $kendaraan->harga_beli ?></td>
		      <td><?php echo $kendaraan->photo ?></td>
		      <td><?php echo $kendaraan->status ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>