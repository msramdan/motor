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
            
<table class='table table-bordered'>       

	    <tr><td width='200'>Invoice <?php echo form_error('invoice') ?></td><td><input type="text" readonly="" class="form-control" name="invoice" id="invoice" placeholder="Invoice" value="<?= $kodeunik ?>" /></td></tr>
      <tr>
                  <td width='200'>pelanggan <?php echo form_error('pelanggan_id') ?></td>
                  <td>
                    <div class="form-group input-group">
                      <input type="hidden" id="pelanggan_id" name="pelanggan_id">
                      <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" readonly="">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-pelanggan">
                          <i class="fa fa-search"></i>
                        </button>
                      </span>
                    </div>
                  </td>   
                </tr>
      <tr>
                  <td width='200'>Kendaraan<?php echo form_error('kendaraan_id') ?></td>
                  <td>
                    <div class="form-group input-group">
                      <input type="hidden" id="kendaraan_id" name="kendaraan_id">
                      <input type="text" id="kd_kendaraan" name="kd_kendaraan" class="form-control" readonly="">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-kendaraan">
                          <i class="fa fa-search"></i>
                        </button>
                      </span>
                    </div>
                    <label for="nama_item_pro">Nama Kendaraan</label>
                    <div class="form-group">
                        <input type="text" name="nama_kendaraan" class="form-control" id="nama_kendaraan" value="-" readonly="">
                    </div>
                    <label for="nama_item_pro">Jenis Kendaraan</label>
                    <div class="form-group">
                        <input type="text" name="nama_jenis" class="form-control" id="nama_jenis" value="-" readonly="">
                    </div>
                    <label for="nama_item_pro">Merk</label>
                    <div class="form-group">
                        <input type="text" name="nama_merek" class="form-control" id="nama_merek" value="-" readonly="">
                    </div>
                    <label for="nama_item_pro">Type</label>
                    <div class="form-group">
                        <input type="text" name="nama_type" class="form-control" id="nama_type" value="-" readonly="">
                    </div>
        
  
                  </td>   
                </tr>
                                


	    <tr><td width='200'>Total Price Sale <?php echo form_error('total_price_sale') ?></td><td><input type="text" class="form-control" name="total_price_sale" id="total_price_sale" placeholder="Total Price Sale" value="<?php echo $total_price_sale; ?>" /></td></tr>
      <tr><td width='200'>Biaya Admin <?php echo form_error('biaya_admin') ?></td><td><input type="text" class="form-control" name="biaya_admin" id="biaya_admin" placeholder="Biaya Admin" value="<?php echo $biaya_admin; ?>" /></td></tr>

      <tr>
            <td width='200'>Type Sale <?php echo form_error('type_sale') ?></td>
            <td><select name="type_sale" id="type_sale" class="form-control" >
                <option value="Cash" >Cash</option>
                <option value="Kredit" >Kredit</option>
              </select><br>
              <div class="form-group">
                        <input type="text" name="jenis_pembayaran" class="form-control" id="jenis_pembayaran" value="" placeholder="Cth : Tunai, Transfer, Dll">
                    </div>

                    <div class="form-group">
                        <input type="number" name="dp" class="form-control" id="dp" value="" placeholder="Uang DP">
                    </div>
                    <div class="form-group">
                        <input type="number" name="lama_cicilan" class="form-control" id="lama_cicilan" value="" placeholder="Lama Cicilan">
                    </div>
                    <div class="form-group">
                        <input type="number" name="bunga_cicilan" class="form-control" id="bunga_cicilan" value="" placeholder="Bunga Cicilan">
                    </div>
            </td>
          </tr>



	    <tr><td width='200'>Tanggal Sale <?php echo form_error('tanggal_sale') ?></td><td><input type="date" class="form-control" name="tanggal_sale" id="tanggal_sale" placeholder="Tanggal Sale" value="<?php echo $tanggal_sale; ?>" /></td></tr>
	    <tr><td width='200'>User Penginput <?php echo form_error('user_id') ?></td><td><input type="text" class="form-control" name="nama_user" id="nama_user" placeholder="User Id" readonly="" value="<?= ucfirst($this->fungsi->user_login()->nama_user) ?>" />

	    <input type="hidden" class="form-control" name="user_id" id="user_id" placeholder="User Id" readonly="" value="<?= ucfirst($this->fungsi->user_login()->user_id) ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="sale_id" value="<?php echo $sale_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('sale') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>

 <div class="modal fade" id="modal-pelanggan">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" arial-label="close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Add Pelanggan</h4>
          </div>
          <div class="modal-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <th>KTP</th>
                        <th>No HP</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pelanggan as $key => $data) { ?>
                    <tr>
                      <td><?= $data->nama_pelanggan ?></td>
                      <td><?= $data->no_ktp ?></td>
                      <td><?= $data->no_hp_pelanggan ?></td>
                      <td>
                        <button class="btn btn-xs btn-info" id="select"
                          data-pelanggan_id="<?php echo $data->pelanggan_id ?>"
                          data-nama_pelanggan="<?php echo $data->nama_pelanggan ?>">
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

     <div class="modal fade" id="modal-kendaraan">
      <div class="modal-dialog">E
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" arial-label="close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Add Kendaraan</h4>
          </div>
          <div class="modal-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Kode Kendaraan</th>
                        <th>Nama Kendaraan</th>
                        <th>Jenis Kendaraan</th>
                        <th>Merk</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kendaraan as $key => $data2) { ?>
                    <tr>
                      <td><?= $data2->kd_kendaraan ?></td>
                      <td><?= $data2->nama_kendaraan ?></td>
                      <td><?= $data2->nama_jenis_kendaraan ?></td>
                      <td><?= $data2->nama_merek ?></td>
                      <td><?= $data2->nama_type ?></td>
                      <td>
                        <button class="btn btn-xs btn-info" id="pilih"
                          data-1="<?php echo $data2->kendaraan_id ?>"
                          data-2="<?php echo $data2->nama_kendaraan ?>"
                          data-3="<?php echo $data2->nama_jenis_kendaraan ?>"
                          data-4="<?php echo $data2->nama_merek ?>"
                          data-5="<?php echo $data2->nama_type ?>"
                          data-6="<?php echo $data2->kd_kendaraan ?>">
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

    <script>
        $(document).on('click','#select',function(){
          $('#pelanggan_id').val($(this).data('pelanggan_id'))
          $('#nama_pelanggan').val($(this).data('nama_pelanggan'))
          $('#modal-pelanggan').modal('hide')
        })

        $(document).on('click','#pilih',function(){
          $('#kendaraan_id').val($(this).data('1'))
          $('#nama_kendaraan').val($(this).data('2'))
          $('#nama_jenis').val($(this).data('3'))
          $('#nama_merek').val($(this).data('4'))
          $('#nama_type').val($(this).data('5'))
          $('#kd_kendaraan').val($(this).data('6'))
          $('#modal-kendaraan').modal('hide')
        })
    </script>

    <script type="text/javascript">
 //Inisiasi awal penggunaan jQuery
 $(document).ready(function(){
  $('#dp').hide(); 
                $('#lama_cicilan').hide();
                $('#bunga_cicilan').hide();

    $(function () {
        $("#type_sale").change(function () {
            if ($(this).val() == "Kredit") {
                $('#dp').show(); 
                $('#lama_cicilan').show();
                $('#bunga_cicilan').show();
                $('#jenis_pembayaran').hide(); 
            } else {
                $('#dp').hide(); 
                $('#lama_cicilan').hide();
                $('#bunga_cicilan').hide();
                $('#jenis_pembayaran').show(); 
            }
        });
    });     

 });
</script>