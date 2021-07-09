<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
    <body>
        <h2 style="margin-top:0px">Karyawan Read</h2>
	        <table class="table">
			    <tr><td>Nama Karyawan</td><td><?php echo $nama_karyawan; ?></td></tr>
			    <tr><td>No Ktp Karyawan</td><td><?php echo $no_ktp_karyawan; ?></td></tr>
			    <tr><td>No Hp Karyawan</td><td><?php echo $no_hp_karyawan; ?></td></tr>
			    <tr><td>Jenis Kelamin</td><td><?php echo $jenis_kelamin; ?></td></tr>
			    <tr><td>Pendidikan</td><td><?php echo $pendidikan; ?></td></tr>
			    <tr><td>Alamat</td><td><?php echo $alamat; ?></td></tr>
			    <tr><td>Unit</td><td><?php echo $unit_id; ?></td></tr>
			    <tr><td>Photo</td><td><?php echo $photo; ?></td></tr>
			    <tr><td></td><td><a href="<?php echo site_url('karyawan') ?>" class="btn btn-default">Cancel</a><a href="<?php echo base_url() ?>karyawan/cetak_data/<?php echo $karyawan_id ?>" class="btn btn-warning">Cetak</a></td></tr>
			</table>
        </body>
    </div>
</div>