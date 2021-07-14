<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA JENIS_PEMBAYARAN</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Nama Jenis Pembayaran <?php echo form_error('nama_jenis_pembayaran') ?></td><td><input type="text" class="form-control" name="nama_jenis_pembayaran" id="nama_jenis_pembayaran" placeholder="Nama Jenis Pembayaran" value="<?php echo $nama_jenis_pembayaran; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="jenis_pembayaran_id" value="<?php echo $jenis_pembayaran_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('jenis_pembayaran') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>