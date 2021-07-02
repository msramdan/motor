
            <div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA KENDARAAN</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
            <div class='row'>
            <div class='col-md-9'>
            <div style="padding-bottom: 10px;"'>
        <?php echo anchor(site_url('kendaraan/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?>
		<?php echo anchor(site_url('kendaraan/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?>
		<?php echo anchor(site_url('kendaraan/word'), '<i class="fa fa-file-word-o" aria-hidden="true"></i> Export Ms Word', 'class="btn btn-primary btn-sm"'); ?></div>
            </div>
            <div class='col-md-3'>
            <form action="<?php echo site_url('kendaraan/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('kendaraan'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
            </div>
        
   
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                
            </div>
        </div>
        <div class="box-body" style="overflow-x: scroll; ">
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Kd Pembelian</th>
		<th>Agen</th>
		<th>Kd Kendaraan</th>
		<th>Nama Kendaraan</th>
		<th>Jenis Kendaraan</th>
        <th>Merek</th>
		<th>Merek</th>
		<th>No Stnk</th>
		<th>No Bpkb</th>
		<th>Deskripsi</th>
		<th>Harga Beli</th>
		<th>Photo</th>
		<th>Status</th>
		<th>Action</th>
            </tr><?php
            foreach ($kendaraan_data as $kendaraan)
            {
                ?>
                <tr>
			<td width="10px"><?php echo ++$start ?></td>
			<td><?php echo $kendaraan->kd_pembelian ?></td>
			<td><?php echo $kendaraan->nama_agen ?></td>
			<td><?php echo $kendaraan->kd_kendaraan ?></td>
			<td><?php echo $kendaraan->nama_kendaraan ?></td>
			<td><?php echo $kendaraan->nama_jenis_kendaraan ?></td>
            <td><?php echo $kendaraan->nama_type ?></td>
			<td><?php echo $kendaraan->nama_merek ?></td>
			<td><?php echo $kendaraan->no_stnk ?></td>
			<td><?php echo $kendaraan->no_bpkb ?></td>
			<td><?php echo $kendaraan->deskripsi ?></td>
			<td><?php echo $kendaraan->harga_beli ?></td>
			<td><a href="<?php echo base_url(); ?>kendaraan/download/<?php echo $kendaraan->photo?>"><i class="ace-icon fa fa-download"></i> Download Logo</td>
			<td><?php echo $kendaraan->status ?></td>
			<td style="text-align:center" width="200px">
				<?php
                echo anchor(site_url('kendaraan/update_harga/'.$kendaraan->kendaraan_id),'<i class="fa fa-upload" aria-hidden="true"></i>','class="btn btn-warning btn-sm"'); 
                echo '  '; 
				echo anchor(site_url('kendaraan/read/'.$kendaraan->kendaraan_id),'<i class="fa fa-eye" aria-hidden="true"></i>','class="btn btn-success btn-sm"'); 
				echo '  '; 
				echo anchor(site_url('kendaraan/update/'.$kendaraan->kendaraan_id),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-primary btn-sm"'); 
				echo '  '; 
				echo anchor(site_url('kendaraan/delete/'.$kendaraan->kendaraan_id),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
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
                    </div>
            </div>
            </div>
            </div>
</div>