<div class="page-title">
  <div class="title_left">
    <h3>DATA SALE</h3>
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
                <tr>
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
                </tr>
                <tr>
                  <td width='200'>item<?php echo form_error('item_id') ?></td>
                  <td>
                    <div class="form-group input-group">
                      <input type="hidden" id="item_id" name="item_id">
                      <input type="text" id="kd_item" name="kd_item" class="form-control" readonly="">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-item">
                          <i class="fa fa-search"></i>
                        </button>
                      </span>
                    </div>
                    <div class="col-md-4">
                      <label for="nama_item_pro">Nama item</label>
                      <div class="form-group">
                        <input type="text" name="nama_item" class="form-control" id="nama_item" value="-" readonly="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label for="nama_item_pro">Jenis item</label>
                      <div class="form-group">
                        <input type="text" name="nama_jenis" class="form-control" id="nama_jenis" value="-" readonly="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label for="nama_item_pro">Merk</label>
                      <div class="form-group">
                          <input type="text" name="nama_merek" class="form-control" id="nama_merek" value="-" readonly="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label for="nama_item_pro">Type</label>
                      <div class="form-group">
                        <input type="text" name="nama_type" class="form-control" id="nama_type" value="-" readonly="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label for="nama_item_pro">Harga Pokok</label>
                      <div class="form-group">
                          <input type="text" name="harga_pokok" class="form-control" id="harga_pokok" value="-" readonly="">
                      </div>
                    </div>
                  </td>   
                </tr>
                <tr><td width='200'>Price Sale <?php echo form_error('total_price_sale') ?></td><td><input type="text" class="form-control" name="total_price_sale" id="total_price_sale" placeholder="Price Sale" value="<?php echo $total_price_sale; ?>" /></td></tr>
                <tr><td width='200'>Biaya Admin <?php echo form_error('biaya_admin') ?></td><td><input type="text" class="form-control" name="biaya_admin" id="biaya_admin" placeholder="Biaya Admin" value="<?php echo $admin_fee->nominal ?>" /></td></tr>
                <tr>
                  <td width='200'>Type Sale <?php echo form_error('type_sale') ?></td>
                  <td>
                    <select name="type_sale" id="type_sale" class="form-control" >
                      <option value="" >-- Pilih --</option>
                      <option value="Cash" >Cash / Onetime Payment </option>
                      <option value="Kredit" >Kredit / Cicilan</option>
                    </select>
                  </td>
                </tr>
                <tr>
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
                <tr><td width='200'>Tanggal Sale <?php echo form_error('tanggal_sale') ?></td><td><input type="text" class="form-control" name="tanggal_sale" id="tanggal_sale" placeholder="Tanggal Sale" value="<?php echo $tanggal_sale; ?>" /></td></tr>
                <div>
                  
                </div>
                <tr>
                  <td width='200'>User Penginput <?php echo form_error('user_id') ?></td>
                  <td>
                    <input type="text" class="form-control" name="nama_user" id="nama_user" placeholder="User Id" readonly="" value="<?= ucfirst($this->fungsi->user_login()->nama_user) ?>" />
                    <input type="hidden" class="form-control" name="user_id" id="user_id" placeholder="User Id" readonly="" value="<?= ucfirst($this->fungsi->user_login()->user_id) ?>" />
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <input type="hidden" name="sale_id" value="<?php echo $sale_id; ?>" />
                    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                    <a href="<?php echo site_url('sale') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
                  </td>
                </tr>
              </table>
            </form>
          </div>
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



     <div class="modal fade" id="modal-item">
      <div class="modal-dialog">E
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" arial-label="close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Add item</h4>
          </div>
          <div class="modal-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Kode item</th>
                        <th>Nama item</th>
                        <th>Jenis item</th>
                        <th>Merk</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($item as $key => $data2) { ?>
                    <tr>
                      <td><?= $data2->kd_item ?></td>
                      <td><?= $data2->nama_item ?></td>
                      <td><?= $data2->nama_jenis_item ?></td>
                      <td><?= $data2->nama_merek ?></td>
                      <td><?= $data2->nama_type ?></td>
                      <td>
                        <button class="btn btn-xs btn-info" id="pilih"
                          data-1="<?php echo $data2->item_id ?>"
                          data-2="<?php echo $data2->nama_item ?>"
                          data-3="<?php echo $data2->nama_jenis_item ?>"
                          data-4="<?php echo $data2->nama_merek ?>"
                          data-5="<?php echo $data2->nama_type ?>"
                          data-6="<?php echo $data2->kd_item ?>"
                           data-7="<?php echo $data2->harga_pokok ?>">
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
<script src="<?= base_url() ?>assets/vendors/fastclick/lib/fastclick.js"></script>
<script src="<?= base_url() ?>assets/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url()?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <script>
      $('#tanggal_sale').daterangepicker({
        "singleDatePicker": true,
        "timePicker": true,
        "timePicker24Hour": true,
        "timePickerSeconds": true,
        "locale": {
            "direction": "ltr",
            "format": "MM/DD/YYYY HH:mm:ss",
            "separator": " - ",
            "applyLabel": "Apply",
            "cancelLabel": "Cancel",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "Su",
                "Mo",
                "Tu",
                "We",
                "Th",
                "Fr",
                "Sa"
            ],
            "monthNames": [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December"
            ],
            "firstDay": 1
        },
        "startDate": "07/13/2021",
        "endDate": "07/19/2021",
        "opens": "center",
        "applyClass": "btn-primary"
    }, function(start, end, label) {
      console.log('New date range selected: ' + start.format('MM/DD/YYYY HH:mm:ss') + ' to ' + end.format('MM/DD/YYYY HH:mm:ss') + ' (predefined range: ' + label + ')');
    });

        $(document).on('click','#select',function(){
          $('#pelanggan_id').val($(this).data('pelanggan_id'))
          $('#nama_pelanggan').val($(this).data('nama_pelanggan'))
          $('#modal-pelanggan').modal('hide')
        })

        $(document).on('click','#pilih2',function(){
          $('#surveyor_id').val($(this).data('surveyor_id'))
          $('#nama_surveyor').val($(this).data('nama_surveyor'))
          $('#modal-surveyor').modal('hide')
        })

        $(document).on('click','#pilih',function(){
          $('#item_id').val($(this).data('1'))
          $('#nama_item').val($(this).data('2'))
          $('#nama_jenis').val($(this).data('3'))
          $('#nama_merek').val($(this).data('4'))
          $('#nama_type').val($(this).data('5'))
          $('#kd_item').val($(this).data('6'))
          $('#harga_pokok').val($(this).data('7'))
          $('#total_price_sale').val($(this).data('7')+$(this).data('7')*0.2)          
          $('#modal-item').modal('hide')
        })
    </script>

    <script type="text/javascript">
 //Inisiasi awal penggunaan jQuery
 $(document).ready(function(){
                $('#dp').hide(); 
                $('#lama_cicilan').hide();
                $('#bunga_cicilan').hide();
                $('#mitra_id').hide();
                $('#karyawan_id').hide();

    $("#type_sale").change(function () {
            if ($(this).val() == "Kredit") {
                $('#dp').show();
                $('#lama_cicilan').show();
                $('#bunga_cicilan').show();
            } else {
                $('#dp').hide(); 
                $('#lama_cicilan').hide();
                $('#bunga_cicilan').hide();
            }
        });


        $("#sales_referral").change(function () {
            if ($(this).val() == "" || $(this).val() == "Datang Langsung" ) {
                $('#mitra_id').hide();
                $('#karyawan_id').hide();
            } else if ($(this).val() == "Karyawan"){
                $('#karyawan_id').show();
                $('#mitra_id').hide();
            }else{
                $('#mitra_id').show();
                $('#karyawan_id').hide();
            }
        });

 });
</script>