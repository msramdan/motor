<div class="page-title">
  <div class="title_left">
    <h3>FORM PEMBAYARAN - <?php echo $invoice ?> (CICILAN)</h3>
  </div>
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="box-body">
            <form action="update_payment" method="post">
              <table class='table table-bordered'>       

                <tr>
                  <td width='200'>Invoice</td>
                  <td>
                    <div class="form-group input-group">
                      <input type="hidden" id="invoicehidden" name="invoicehidden" value="<?php echo $invoice ?>">
                      <input type="text" id="invoice" name="invoice" class="form-control" readonly="" value="<?php echo $invoice ?>">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#detail_invoice">
                          <i class="fa fa-eye"></i>
                        </button>
                      </span>
                    </div>
                    <input type="hidden" name="iditem" id="iditem" value="<?php echo $item_id ?>">
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
                <tr id="step1">
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
                <tr id="step2" hidden>
                  <td colspan="2">
                    <table class="table table-striped tabel-payment-detail">
                      <tr>
                        <th>No</th>
                        <th>Item</th>
                        <th>Harga Pokok</th>
                        <th>Harga Jual</th>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>
                          <?php echo $nama_item.' ('.$nama_type.'-'.$nama_merek.'/'.$tahun_buat.')' ?>
                        </td>
                        <td>
                          Rp.<?php echo $harga_pokok ?>
                        </td>
                        <td>
                          <input type="text" class="form-control input-nilai" name="total_price_sale" id="total_price_sale" placeholder="Price Sale" value="<?php echo $total_price_sale; ?>">
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td>
                          Biaya admin
                        </td>
                        <td>
                          <input type="text" class="form-control input-nilai-khusus" name="biaya_admin" id="biaya_admin" placeholder="Biaya Admin" value="<?php echo $admin_fee->nominal ?>">
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td>Lama Cicilan<span id="warning1" style="margin: 0 10px;"></span></td>
                        <td>
                          <input type="text" name="lama_cicilan" class="form-control input-nilai" id="lama_cicilan" value="" placeholder="Cicilan(x)">                          
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><b>Bayaran Per-bulan (Tanpa Bunga)</b></td>
                        <td>
                          <p><b><span id="bayaranpbulantb">0</span>/Bulan</b></p>
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td>Bunga %</td>
                        <td>
                          <input type="text" name="bunga_cicilan" class="form-control input-nilai" id="bunga_cicilan" value="" placeholder="Bunga/bulan(%)">
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><b>Bayaran Per-bulan (Bunga)</b></td>
                        <td>
                          <p><b><span class="bayaranpbulanb">0</span>/Bulan<input type="hidden" name="bayaranpbulanb" class="bayaranpbulanb"></b></p>
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td>DP</td>
                        <td>
                          <input type="text" name="dp" class="form-control input-nilai-khusus" id="dp" value="" placeholder="Uang DP">
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><b>Total</b></td>
                        <td><p id="txttotalbayarnya">0</p><input type="hidden" name="wajibdibayar" id="wajibdibayar" value=""></td>
                      </tr>
                    </table>
                    <span id="icon-oke"></span>
                    <span id="payment-info-action"><button class="btn btn-primary btn-konfirmasi-payment">Konfirmasi</button></span>
                  </td>
                </tr>
                
                <tr id="step3" hidden>
                  <td width='200'>Jenis Pembayaran</td>
                  <td>
                    <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control" >
                      <option value="" >-- Pilih --</option>
                      <?php foreach ($jenis_pembayaran as $key => $data) { ?>
                      <option value="<?= $data->jenis_pembayaran_id ?>" ><?= $data->nama_jenis_pembayaran ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr id="step4" hidden>
                  <td width='200'>Tanggal Sale <?php echo form_error('tanggal_sale') ?></td><td><input type="text" class="form-control" name="tanggal_sale" id="tanggal_sale" placeholder="Tanggal Sale" value="<?php echo $tanggal_sale; ?>"><input type="hidden" name="tanggalsalehidden" id="tanggalsalehidden" value=""></td>
                </tr>
                <tr>
                  <td colspan="2" align="center" id="notes">Selesaikan isian diatas terlebih dahulu untuk tahap selanjutnya</td>
                </tr>
              </table>
            </form>
          </div>
        </div>
      </div>

    <div class="modal fade" id="detail_invoice">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" arial-label="close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Detail</h4>
          </div>
          <div class="modal-body table-responsive">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
            <td>Nama Pelanggan</td><td><?php echo $nama_pelanggan.' (ID: '.$no_ktp.')' ?></td>
          </tr>
          <tr>
            <td>Item</td><td><?php echo $nama_item ?></td>
          </tr>
          <tr>  
            <td>Tipe Sale</td><td><?php echo $type_sale ?></td>
          </tr>
          <tr>  
            <td>Waktu data masuk</td><td><?php echo $tanggal_sale ?></td>
          </tr>
          <tr>  
            <td>Penginput</td><td><?php echo $nama_user ?></td>
          </tr>
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

<script src="<?= base_url() ?>assets/vendors/fastclick/lib/fastclick.js"></script>
<script src="<?= base_url() ?>assets/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url()?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <script>
      function stepstatus(w, message) {
        $('#notes').html('<i class="fa fa-circle-o-notch fa-spin"></i> ' + message)
        setTimeout(function(){
          $('#step' + w).removeAttr('hidden')
          $('#notes').html('Selesaikan isian diatas terlebih dahulu untuk tahap selanjutnya')
        }, 1000)
      }

      $(document).ready(function(){
        $('#mitra_id').hide();
        $('#karyawan_id').hide();

        $('#tanggalsalehidden').val(moment().toISOString())
      });

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
        "startDate": moment().format('MM/DD/YYYY HH:mm:ss'),
        "opens": "center",
        "applyClass": "btn-primary"
    }, function(start, end, label) {
      console.log('New date range selected: ' + start.format('MM/DD/YYYY HH:mm:ss') + ' to ' + end.format('MM/DD/YYYY HH:mm:ss') + ' (predefined range: ' + label + ')');
      $('#tanggalsalehidden').val(start.toISOString())
    });

  $("#sales_referral").change(function () {
    if ($(this).val() == "" || $(this).val() == "Datang Langsung" ) {
      $('#mitra_id').hide();
      $('#karyawan_id').hide();
    } else if ($(this).val() == "Karyawan"){
      $('#karyawan_id').show();
      $('#mitra_id').hide();
    } else {
      $('#mitra_id').show();
      $('#karyawan_id').hide();
    }
    stepstatus('2','Memproses')
  });

  function disableeditinfohargakah(answer){
    $('.tabel-payment-detail').children('tbody').children('tr').find('input').prop('readonly', answer);
  }

  $(document).on('click', '.btn-konfirmasi-payment', function (e) {
    e.preventDefault()
    disableeditinfohargakah(true)
    $('.tabel-payment-detail tr td input').attr('disabled');
    $('#icon-oke').html('<i class="fa fa-check" style="font-size: 2em;"></i>')
    $('#payment-info-action').html('<button class="btn btn-info" id="edit-payment-detail">Edit</button>')
    stepstatus('3','Memproses')
  });

  $(document).on('click','#edit-payment-detail', function (e) {
    e.preventDefault()
    disableeditinfohargakah(false)
    $('#icon-oke').html('')
    $('#payment-info-action').html('<button class="btn btn-primary btn-konfirmasi-payment">Konfirmasi</button>')
  })


  $(document).on('propertychange change click keyup input paste ready','.input-nilai-khusus', function() {
    var dp = $('#dp').val()
    var biayaadmin = $('.input-nilai-khusus').val()

    $('#txttotalbayarnya').text(parseInt(dp) + parseInt(biayaadmin))
    $('#wajibdibayar').val(parseInt(dp) + parseInt(biayaadmin))
  })

  $(document).on("propertychange change click keyup input paste ready", ".input-nilai", function() {
      var sum = 0;
      $(".input-nilai").each(function(){
          sum += +$(this).val();
      });

      var cicilan = $('#lama_cicilan').val()

      var divided = sum/parseInt(cicilan)


      if (!divided || divided == Infinity) {
        $('#warning1').html('<i class="fa fa-warning" style="color: #e2c227;"></i>')
        $('#bayaranpbulantb').text(0);
      } else {
        $('#warning1').html('')
        $("#bayaranpbulantb").text(divided.toFixed(2));
      }

      var bunga = $('#bunga_cicilan').val()
      var dividedwithbunga = divided + (divided * bunga)

      var interestRate = ((bunga/100) + 1);
      var resultnya = (divided * Math.pow(interestRate, cicilan)).toFixed(2);

      $('.bayaranpbulanb').text(resultnya)
      $('.bayaranpbulanb').val(resultnya)
  });


  $("#jenis_pembayaran").change(function () {
    stepstatus('4','Memproses')
  })
  
  $("#tanggal_sale").change(function () {
    $('#notes').html(`
                <td colspan="2" align="center">
                  <input type="hidden" name="sale_id" value="<?php echo $sale_id; ?>" />
                  <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i>Simpan</button>
                  <a href="<?php echo site_url('sale') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Batal</a>
                </td>
              `)
  });

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
          stepstatus('2','Memproses')
        })


        $(document).on('click','#select',function(){
          $('#pelanggan_id').val($(this).data('pelanggan_id'))
          $('#nama_pelanggan').val($(this).data('nama_pelanggan'))
          $('#modal-pelanggan').modal('hide')
          stepstatus('3','Memproses')
        })

        $(document).on('click','#pilih2',function(){
          $('#surveyor_id').val($(this).data('surveyor_id'))
          $('#nama_surveyor').val($(this).data('nama_surveyor'))
          $('#modal-surveyor').modal('hide')
        })
    </script>