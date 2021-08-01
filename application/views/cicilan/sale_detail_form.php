<div class="page-title">
	<div class="title_left">
		<h3>KELOLA DATA SALE_DETAIL</h3>
	</div>
<div class="clearfix"></div>
	<div class="row">
	    <div class="col-md-12 col-sm-12 col-xs-12">
	        <div class="x_panel">
		        <div class="box-body">
		        	<form action="<?php echo $action; ?>" method="post">
            			<table class='table table-bordered'>        
            				<tr id="step1" hidden>
				              <td width='200'>Surveyor <?php echo form_error('surveyor_id') ?></td>
				              <td>
				                <div class="form-group input-group">
				                  <input type="hidden" id="surveyor_id" name="surveyor_id">
				                  <input type="text" id="nama_surveyor" name="nama_surveyor" class="form-control" readonly="">
				                  <span class="input-group-btn">
				                    <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-surveyor">
				                      <i class="fa fa-search"></i>
				                    </button>
				                  </span>
				                </div>
				                Note : Kosongkan jika pembelian di bayar cash / Onetime Payment
				              </td>
				            </tr>
				            <tr id="step2" hidden>
				              <td width='200'>Sales Referral<?php echo form_error('sales_referral') ?></td>
				              <td>
				                <select name="sales_referral" id="sales_referral" class="form-control" >
				                  <option value="" >-- Pilih --</option>
				                  <option value="Datang Langsung" >Datang Langsung</option>
				                  <option value="Karyawan" >Karyawan</option>
				                  <option value="Mitra Sales" >Mitra Sales</option>
				                </select>
				                <div class="form-group" style="margin-top: 10px">
				                  <select name="mitra_id" id="mitra_id" class="form-control" >
				                        <option value="" >-- Pilih --</option>
				                          <?php foreach ($mitra as $key => $data) { ?>
				                              <option value="<?= $data->mitra_id ?>" ><?= $data->nama_mitra ?></option>
				                          <?php } ?>
				                  </select>
				                </div>
				                <div class="form-group" style="margin-top: 10px">
				                  <select name="karyawan_id" id="karyawan_id" class="form-control" >
				                      <option value="" >-- Pilih --</option>
				                        <?php foreach ($karyawan as $key => $data) { ?>
				                              <option value="<?= $data->karyawan_id ?>" ><?= $data->nama_karyawan ?></option>
				                          <?php } ?>
				                  </select>
				                </div>
				              </td>   
				            </tr>-->
				            <tr id="step9" hidden>
				              <td width='200'>Type Sale <?php echo form_error('type_sale') ?></td>
				              <td>
				                <select name="type_sale" id="type_sale" class="form-control" >
				                  <option value="" >-- Pilih --</option>
				                  <option value="Cash" >Cash / Onetime Payment </option>
				                  <option value="Kredit" >Kredit / Cicilan</option>
				                </select>
				              </td>
				            </tr>
				            <tr id="step10" hidden>
				              <td width='200'>Jenis Pembayaran <?php echo form_error('jenis_pembayaran') ?></td>
				              <td>
				                <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control" >
				                  <option value="" >-- Pilih --</option>
				                  <?php foreach ($jenis_pembayaran as $key => $data) { ?>
				                  <option value="<?= $data->jenis_pembayaran_id ?>" ><?= $data->nama_jenis_pembayaran ?></option>
				                  <?php } ?>
				                </select>
				                <div class="col-md-4">
				                  <div class="form-group" style="margin-top: 10px">
				                    <input type="text" name="lama_cicilan" class="form-control" id="lama_cicilan" value="" placeholder="Cicilan(x)">
				                  </div>
				                </div>
				                <div class="col-md-4">
				                  <div class="form-group" style="margin-top: 10px">
				                    <input type="text" name="bunga_cicilan" class="form-control" id="bunga_cicilan" value="" placeholder="Bunga/bulan(%)">
				                  </div>
				                </div>
				                <div class="col-md-4">
				                  <div class="form-group" style="margin-top: 10px">
				                    <input type="text" name="dp" class="form-control" id="dp" value="" placeholder="Uang DP">
				                  </div>
				                </div>
				              </td>
				            </tr>
	    
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- surveyor -->
 <div class="modal fade" id="modal-surveyor">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" arial-label="close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Add Surveyor</h4>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-bordered table-striped" id="table1">
            <thead>
                <tr>
                    <th>Nama Surveyor</th>
                    <th>No HP</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                  <td colspan="3">
                    <button class="btn btn-md btn-info" id="pilih2"
                      data-surveyor_id=""
                      data-nama_surveyor=""
                      style="width: 100%;">
                      <i class="fa fa-check"></i> Kosongkan
                    </button>
                  </td>
                </tr>
                <?php foreach ($karyawan as $key => $data) { ?>
                <tr>
                  <td><?= $data->nama_karyawan ?></td>
                  <td><?= $data->no_hp_karyawan ?></td>
                  <td>
                    <button class="btn btn-xs btn-info" id="pilih2"
                      data-surveyor_id="<?php echo $data->karyawan_id ?>"
                      data-nama_surveyor="<?php echo $data->nama_karyawan ?>">
                      <i class="fa fa-check"></i> Select
                    </button>
                  </td>
                </tr>
              <?php } ?>

            </tbody>

        </table>
        
      </div>
      
    </div>
  </div>
  
</div>