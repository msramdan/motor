<div class="page-title">
                          <div class="title_left">
                          <h3>KELOLA DATA SALE</h3>
              </div>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
        <div class="box-body">
        
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Invoice <?php echo form_error('invoice') ?></td><td><input type="text" class="form-control" name="invoice" id="invoice" placeholder="Invoice" value="<?php echo $invoice; ?>" /></td></tr>
	    <tr>
            <td width='200'>pelanggan <?php echo form_error('pelanggan_id') ?></td>
            <td><select name="pelanggan_id" class="form-control">
                <option value="">-- Pilih -- </option>
                <?php foreach ($pelanggan as $key => $data) { ?>
                  <?php if ($pelanggan_id == $data->pelanggan_id) { ?>
                    <option value="<?php echo $data->pelanggan_id ?>" selected><?php echo $data->nama_pelanggan ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $data->pelanggan_id ?>"><?php echo $data->nama_pelanggan ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
          </tr>

	    <tr><td width='200'>Kendaraan Id <?php echo form_error('kendaraan_id') ?></td><td><input type="text" class="form-control" name="kendaraan_id" id="kendaraan_id" placeholder="Kendaraan Id" value="<?php echo $kendaraan_id; ?>" /></td></tr>


	    <tr><td width='200'>Total Price Sale <?php echo form_error('total_price_sale') ?></td><td><input type="text" class="form-control" name="total_price_sale" id="total_price_sale" placeholder="Total Price Sale" value="<?php echo $total_price_sale; ?>" /></td></tr>
	    <tr><td width='200'>Type Sale <?php echo form_error('type_sale') ?></td><td><input type="text" class="form-control" name="type_sale" id="type_sale" placeholder="Type Sale" value="Cash" readonly="" /></td></tr>
	    <tr><td width='200'>Tanggal Sale <?php echo form_error('tanggal_sale') ?></td><td><input type="date" class="form-control" name="tanggal_sale" id="tanggal_sale" placeholder="Tanggal Sale" value="<?php echo $tanggal_sale; ?>" /></td></tr>
	    <tr><td width='200'>User Penginput <?php echo form_error('user_id') ?></td><td><input type="text" class="form-control" name="nama_user" id="nama_user" placeholder="User Id" readonly="" value="<?= ucfirst($this->fungsi->user_login()->nama_user) ?>" />

	    <input type="hidden" class="form-control" name="user_id" id="user_id" placeholder="User Id" readonly="" value="<?= ucfirst($this->fungsi->user_login()->user_id) ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="sale_id" value="<?php echo $sale_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('sale') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>