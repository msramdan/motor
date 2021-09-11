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

                <tr>
                  <td width='200'>Invoice <?php echo form_error('invoice') ?></td><td><input type="text" readonly="" class="form-control" name="invoice" id="invoice" placeholder="Invoice" value="<?= $kodeunik ?>" /></td>
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
                    <input type="hidden" class="form-control" name="total_price_sale" id="total_price_sale" placeholder="Price Sale" value="<?php echo $total_price_sale; ?>" />
                  </td>   
                </tr>

                <tr id="step2" hidden>
                  <td width='200'>pelanggan <?php echo form_error('pelanggan_id') ?></td>
                  <td>
                    <div class="form-group input-group">
                      <input type="hidden" id="pelanggan_id" name="pelanggan_id">
                      <input type="hidden" id="no_ktp_pelanggan" name="no_ktp_pelanggan">
                      <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" readonly="">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-pelanggan">
                          <i class="fa fa-search"></i>
                        </button>
                      </span>
                    </div>
                  </td>   
                </tr>
                <tr id="step3" hidden>
                  <td width='200'>Durasi Cicilan</td>
                  <td>
                    <div class="form-group input-group" style="max-width: 120px">
                      <input type="number" id="durasi_cicil" name="durasi_cicil" class="form-control" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat btn-check-durasicicilan">
                          <i class="fa fa-check"></i>
                        </button>
                      </span>
                    </div>
                    <p>*Jika 0, otomatis akan masuk sebagai data one-time-paymen, selain itu sebagai data cicilan</p>
                  </td>   
                </tr>
                <tr hidden>
                  <td width='200'>User Penginput <?php echo form_error('user_id') ?></td>
                  <td>
                    <input type="text" class="form-control" name="nama_user" id="nama_user" placeholder="User Id" readonly="" value="<?= ucfirst($this->fungsi->user_login()->nama_user) ?>" />
                    <input type="hidden" class="form-control" name="user_id" id="user_id" placeholder="User Id" readonly="" value="<?= ucfirst($this->fungsi->user_login()->user_id) ?>" />
                    <input type="text" class="form-control" name="tanggal_sale" id="tanggal_sale" placeholder="Tanggal Sale" value="" />
                  </td>
                </tr>
                <tr id="step4">
                  
                </tr>
                <tr id="step5" hidden>

                </tr>
                <tr>
                  <td colspan="2" align="center" id="notes">Selesaikan isian diatas terlebih dahulu untuk tahap selanjutnya</td>
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
                          data-nama_pelanggan="<?php echo $data->nama_pelanggan ?>" data-no_ktp="<?php echo $data->no_ktp ?>">
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
      <div class="modal-dialog">
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
                    <?php
                    if ($item) {
                      foreach ($item as $key => $data2) { ?>
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
                  <?php }
                } else {
                  ?>
                    <tr>
                      <td colspan="6" align="center" style="padding: 5em 0;"> Tidak ada item siap jual disini, mulai <span><a class="btn btn-primary btn-xs" href="<?php echo base_url() ?>item/create">tambah item</a></span>
                      </td>
                    </tr>
                  <?php
                }
                   ?> 

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
        if (w === 'notes') {
          return
        }

        setTimeout(function(){
          $('#step' + w).removeAttr('hidden')
          $('#notes').html('Selesaikan isian diatas terlebih dahulu untuk tahap selanjutnya')
        }, 1000)
      }

      $(document).ready(function(){
        $('#dp').hide(); 
        $('#lama_cicilan').hide();
        $('#bunga_cicilan').hide();
        $('#mitra_id').hide();
        $('#karyawan_id').hide();
        $('#tanggal_sale').val(moment().toISOString())
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
          $('#no_ktp_pelanggan').val($(this).data('no_ktp'))
          $('#modal-pelanggan').modal('hide')
          stepstatus('3','Memproses')
        })

        $('#durasi_cicil').on('change input', function() {

          $('.btn-check-durasicicilan').html('<i class="fa fa-circle-o-notch fa-spin"></i>')
          const durasicicilan = $(this).val()
          const invoice = $('#invoice').val()
          const pelanggan_id = $('#pelanggan_id').val()
          const item_id = $('#item_id').val()
          const user_id = $('#user_id').val()
          const total_price_sale = $('#total_price_sale').val()

          console.log(durasicicilan)

          $('#step4').attr('hidden','true')
          if (durasicicilan > 2) {

            stepstatus('4','Mencari histori data pelanggan')
            setTimeout(function(){

              var noktp = $('#no_ktp_pelanggan').val()

              $.ajax({
                 url: '<?php echo base_url() ?>r_cicilan/cek_history_pelanggan',
                 type: 'post',
                 data: {
                      noktp: noktp
                  },
                  fail: function() {
                      alert('Something is wrong');
                  },
                  error: function() {
                      alert('Something is wrong');
                  },
                  success: function(data) {
                    
                    var ano = JSON.parse(data)

                    if (ano != 'not found') {
                      $('#step4').html(`
                        <td colspan="2" align="center">
                          <div>
                            <h5>Data ${ano} Tersedia!</h5>
                            <button type="button" class="btn btn-primary btn-konfirmasi-cek-infopelanggaan">OK</button>
                            <a class="btn btn-primary btn-success" target="_blank" rel="noopener noreferrer" href="<?php echo base_url().'Lap_historypel/find?id='?>${ano}">CEK</a>
                          </div>
                        </td>
                      `)
                    } else {
                      $('#step4').html(`
                        <td colspan="2" align="center">
                          <div>
                            <h5>Tidak Ada Data</h5>
                            <button type="button" class="btn btn-primary btn-konfirmasi-cek-infopelanggaan">OK</button>
                          </div>
                        </td>
                      `)
                    }
                  }
              });

              $('.btn-check-durasicicilan').html('<i class="fa fa-check"></i>')  
            
            },2000)


          } else if(durasicicilan == 0) {
            stepstatus('notes','Memproses')
            setTimeout(function(){
              $('.btn-check-durasicicilan').html('<i class="fa fa-check"></i>')  
            },2000)
            
            $('#notes').html(`
                <td colspan="2" align="center">
                  <input type="hidden" name="sale_id" value="<?php echo $sale_id; ?>" />
                  <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i>Simpan</button>
                  <a class="btn btn-primary" href="<?php echo base_url() ?>r_onetimep/saveandedit?invoice=${invoice}&idp=${pelanggan_id}&buy=${item_id}&st=Cash&d=${moment().toISOString()}&pc=${total_price_sale}&user_id=${user_id}"><i class="fa fa-card"></i>Lanjut Pembayaran</a>
                  <a href="<?php echo site_url('sale') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
                </td>
              `)
          } else {
            stepstatus('4','Mencari histori data pelanggan')
            setTimeout(function(){
              $('.btn-check-durasicicilan').html('<i class="fa fa-warning"></i>')  
            },2000)
            $('#step4').html(`
                <td colspan="2" align="center">
                  Cicilan terlalu sedikit
                </td>
              `)
            }
        })

        $(document).on('click', '.btn-konfirmasi-cek-infopelanggaan', function() {
          const durasicicilan = $(this).parents('span.input-group-btn').prev().val()
          const invoice = $('#invoice').val()
          const pelanggan_id = $('#pelanggan_id').val()
          const item_id = $('#item_id').val()
          const user_id = $('#user_id').val()
          const total_price_sale = $('#total_price_sale').val()
          stepstatus('notes','Memproses')
          $('#notes').html(`
                <td colspan="2" align="center">
                  <input type="hidden" name="sale_id" value="<?php echo $sale_id; ?>" />
                  <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i>Simpan</button>
                  <a class="btn btn-primary" href="<?php echo base_url() ?>r_cicilan/saveandedit?invoice=${invoice}&idp=${pelanggan_id}&buy=${item_id}&st=Kredit&d=${moment().toISOString()}&pc=${total_price_sale}&ci=${durasicicilan}&user_id=${user_id}"><i class="fa fa-card"></i>Lanjut Pembayaran</a>
                  <a href="<?php echo site_url('sale') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
                </td>
              `)
        })

        $(document).on('click','#pilih2',function(){
          $('#surveyor_id').val($(this).data('surveyor_id'))
          $('#nama_surveyor').val($(this).data('nama_surveyor'))
          $('#modal-surveyor').modal('hide')
        })

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
    </script>