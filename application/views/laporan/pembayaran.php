<div class="page-title">
    <div class="title_left">
        <h3>LAPORAN PEMBAYARAN</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="box-body">
                <form class="form-horizontal">
                  <fieldset>
                    <div class="col-md-10">
                        <div class="control-group">
                          <div class="controls">
                            <div class="input-prepend input-group">
                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              <input type="text" name="datarange-picker" id="datarange-picker" class="form-control" value="01/01/2016 - 01/25/2016" />
                              <input type="hidden" name="tbtglstart" id="tbtglstart" value="<?php echo date('Y-m-d') ?>">
                              <input type="hidden" name="tbtglend" id="tbtglend" value="<?php echo date('Y-m-d') ?>">
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-large btn-block btninitsearch">CARI</button>
                    </div>
                    <div class="col-md-12">
                        <div>
                            <div class="x_panel" style="height: auto;">
                              <div class="x_title">
                                <h2>Filter</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                  <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content" style="display: none;">
                                <div class="col-12">
                                    <table class="table">
                                        <tr>
                                            <td>Invoice</td>
                                            <td>:</td>
                                            <td><input type="text" name="tbidpenjualan" id="tbidpenjualan"></td>
                                        </tr>
                                        <tr>
                                            <td>Nama Pelanggan</td>
                                            <td>:</td>
                                            <td><input type="text" name="tbnamapelanggan" id="tbnamapelanggan"></td>
                                        </tr>
                                        <tr>
                                            <td>Objek</td>
                                            <td>:</td>
                                            <td>
                                                <select id="selectobjek" name="selectobjek">
                                                    <option value="">ALL</option>
                                                    <option value="dp cicilan">Angsuran (DP)</option>
                                                    <option value="bayar cicilan">Angsuran (Bayar Cicilan)</option>
                                                    <option value="bayar denda">Denda</option>
                                                    <option value="one time payment">One Time Payment   </option>
                                                    <option value="biaya admin">Admin</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kategori</td>
                                            <td>:</td>
                                            <td>
                                                <select id="selectkategori" name="selectkategori">
                                                    <option value="">ALL</option>
                                                    <?php foreach ($kategori as $key => $data) { ?>
                                                        <option value="<?php echo $data->kategori_id ?>"><?php echo $data->nama_kategori ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                  </fieldset>
                </form>
                <div id="datawrapper" style="margin-top: 3vh;">
                    <div class="info" style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                        <div class="icon"><i class="fa fa-database" style="font-size: 65px"></i></div>
                        <h3 class="title" style="color: #9d9d9d;s">Data pembayaran akan muncul disini</h3>
                    <div>
                </div>
                <p><span><i class="fa fa-question-circle"></i></span> Mulai dengan memilih tanggal pembayaran yang terjadi</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?php echo base_url()?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript">

    function fetch_payment_report() {
        $('#datawrapper').html(`<div class="info" style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                                <div class="icon"><i class="fa fa-circle-o-notch fa-spin" style="font-size: 65px"></i></div>
                                <h3 class="title" style="color: #9d9d9d;s">Memproses Permintaan...</h3>
                            <div>`)

        const from = $('#tbtglstart').val()
        const end = $('#tbtglend').val()

        const idpenjualan = $('#tbidpenjualan').val()
        const namapelanggan = $('#tbnamapelanggan').val()

        const selectkategori = $('#selectkategori').val()
        const selectobjek = $('#selectobjek').val()

        $.ajax({
            type : "POST",
            url  : "<?php echo base_url() ?>/Lap_pembayaran/fetch_tabel_pembayaran",
            data : {
                fromDate: from,
                toDate: end,
                idpenjualan: idpenjualan,
                namapelanggan: namapelanggan,
                selectkategori: selectkategori,
                selectobjek: selectobjek,
                allunit: 'false'
            },
            success: function(data){
                // const dt = JSON.parse(data)
                setTimeout(function(){
                    $('#datawrapper').html(data);
                },2000)
            },
            error: function(e){
              setTimeout(function(){
                    $('#datawrapper').html('Server mengalami masalah, silahkan coba lagi');
                },2000)
            }
        });
    }

    $(document).on('click','.btninitsearch', function(e){
        e.preventDefault()
        fetch_payment_report()
    });


    $('#datarange-picker').daterangepicker({
        "startDate": moment().format('DD-MM-YYYY'),
        "endDate": moment().format('DD-MM-YYYY')
    }, function(start, end, label) {
      console.log("New date range selected: " + start.format('YYYY-MM-DD') + " to " + end.format('YYYY-MM-DD') + " (predefined range: " + label + ")")
      $('#tbtglstart').val(start.format('YYYY-MM-DD'))
      $('#tbtglend').val(end.format('YYYY-MM-DD'))
    });


</script>